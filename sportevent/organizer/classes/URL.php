<?php 


class URL {
    
    public $full, $normal, $banner, $thumbnail, $sponsor, $merchandise;
    
    public function __construct() {
        
        $this->full         = $this->full_url($_SERVER);
        $this->normal       = $this->removeFilenameInURL($this->full);
        $this->banner       = "http://x-cow.com/sportevent/organizer/img/event_banner/";
        $this->thumbnail    = "http://x-cow.com/sportevent/organizer/img/event_thumbnail/";
        $this->sponsor      = "http://x-cow.com/sportevent/organizer/img/event_sponsor/";
        $this->merchandise  = "http://x-cow.com/sportevent/admin/img/merchandises/";
    }
    
    private function url_origin( $s, $use_forwarded_host = false ) {
        
        $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
        $sp       = strtolower( $s['SERVER_PROTOCOL'] );
        $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
        $port     = $s['SERVER_PORT'];
        $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
        $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
        $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
        return $protocol . '://' . $host;
    }

    private function full_url( $s, $use_forwarded_host = false ){
        
        return $this->url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
        
    }

    private function removeFilenameInURL($url){
        $file_info = pathinfo($url);
        return isset($file_info['extension'])
            ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $url)
            : $url;
    }
      
}





?>