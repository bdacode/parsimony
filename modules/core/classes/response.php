<?php

/**
 * Parsimony
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to contact@parsimony.mobi so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Parsimony to newer
 * versions in the future. If you wish to customize Parsimony for your
 * needs please refer to http://www.parsimony.mobi for more information.
 *
 *  @authors Julien Gras et Benoît Lorillot
 *  @copyright  Julien Gras et Benoît Lorillot
 *  @version  Release: 1.0
 * @category  Parsimony
 * @package core\classes
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace core\classes;

/**
 *  Response Class 
 *  Manages HTTP Response 
 */
class response {

    /**
     * @var integer status of HTTP response
     */
    protected $status;

    /**
     * @var string format of HTTP response
     */
    protected $format = 'html';

    /**
     * @var string charset of HTTP response
     */
    protected $charset = 'utf-8';

    /**
     * @var array of headers 
     */
    protected $headers = array();

    /** @var theme object */
    protected $theme;

    /** @var string $body */
    protected $body = '';

    /**
     * Construct the HTTP response
     */
    public function __construct($status = 200) {
        $this->status = $status;
    }
    /**
     * Get content to client
     * @param mixed $body optional
     */
     public function getContent() {
        return $this->body;
     }
     
    /**
     * Send content to client
     * @param mixed $body optional
     */
    public function setContent($body = '',$status = FALSE) {
	if($status !== FALSE) $this->setStatus($status);
        if (is_object($body) && get_class($body) == 'core\classes\page') {

            app::$request->page = $body;
            
            \app::dispatchEvent('pageLoad');

            /* THEME */
            $this->theme = \theme::get(THEMEMODULE, THEME, THEMETYPE);
            $structure = $body->getStructure();
            if (defined('PARSI_ADMIN')) {
                $adm = new \admin\blocks\toolbar("admintoolbar");
                $this->body = $adm->display();
            } else {
                if ($structure)
                    $this->body = $this->theme->display();
                else
                    $this->body = $body->display();
                   
                if ((BEHAVIOR == 1 || BEHAVIOR==2) && !\app::$request->getParam('popup')){
                     $this->timer = microtime(true) - app::$timestart; 
                    $this->body .= '<script>window.parent.history.replaceState({url:document.location.pathname}, document.title, document.location.pathname.replace("?parsiframe=ok","").replace("parsiframe=ok",""));window.parent.TOKEN="'.TOKEN.'";window.parent.$_GET='.  json_encode($_GET).';window.parent.$_POST='. json_encode($_POST).';window.parent.document.getElementById("infodev_timer").innerHTML="' . round($this->timer, 4) . ' s";window.parent.document.getElementById("infodev_module").innerHTML="' . MODULE . '";window.parent.document.getElementById("infodev_theme").innerHTML="' . THEME . '";window.parent.document.getElementById("infodev_page").innerHTML="' . $body->getId() . '";window.parent.ParsimonyAdmin.initIframe();  </script>';
                }
            }
	    if ($structure){
		ob_start();
		include('core/views/desktop/index.php');
		$this->body = ob_get_clean();
	    }
		
//            @todo compact HTML
//            $search = array('/\>[^\S ]+/s', '/[^\S ]+\</s');
//            $replace = array('>', '<');
//            $this->body = preg_replace($search, $replace, $this->body);
        }else {
            $this->body = $body;
        }
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $this->status . ' ' . self::$HTTPstatus[$this->status], true, $this->status);
        header('Content-type: ' . self::$mimeTypes[$this->format] . '; charset=' . $this->charset);
        foreach ($this->headers AS $label => $header) {
            header($label . ': ' . $header);
        }
        return $this->body;
    }

    /**
     * Set HTTP status
     * @param integer $status
     */
    public function setStatus($status) {
        if (isset(self::$HTTPstatus[$status]))
            $this->status = $status;
        else
            throw new \Exception(t('Parsimony doesn\'t know this HTTP status', FALSE));
    }

    /**
     * Get HTTP status
     * @return integer
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set format of response
     * @param string $format
     */
    public function setFormat($format) {
        if (isset(self::$mimeTypes[$this->format]))
            $this->format = $format;
        else
            throw new \Exception(t('Parsimony doesn\'t know this HTTP format', FALSE));
    }

    /**
     * Get format of response
     * @return string
     */
    public function getFormat() {
        return $this->format;
    }

    /**
     * Set header of response
     * @param string $label
     * @param string $head
     */
    public function setHeader($label, $head) {
        $this->headers[$label] = $head;
    }

    /**
     * Set header of response
     * @param string $label
     * @return string
     */
    public function getHeader($label) {
        return $this->headers[$label];
    }

    /**
     * HTTP status codes
     * array of status
     */
    static public $HTTPstatus = array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        118 => 'Connexion timed out',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        310 => 'Too Many Redirect',
        324 => 'Empty Response',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        426 => 'Upgrade Required',
	428 => 'Precondition Required',
	429 => 'Too Many Requests',
	431 => 'Request Header Fields Too Large',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded',
	511 => 'Network Authentication Required'
    );

    /**
     * Type MIME
     */
    static public $mimeTypes = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/x-javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        // ms office
        'doc' => 'application/msword',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'ppt' => 'application/vnd.ms-powerpoint',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );

}

?>