<?php
	class Util_model extends CI_Model{

        public function getToken($length)
        {
            $token = "";
            $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
            $codeAlphabet .= "0123456789";
            $max = strlen($codeAlphabet) - 1;
            for ($i = 0; $i < $length; $i ++) {
                $token .= $codeAlphabet[$this->cryptoRandSecure(0, $max)];
            }
            return $token;
        }
        
        private function cryptoRandSecure($min, $max)
        {
            $range = $max - $min;
            if ($range < 1) {
                return $min; // not so random...
            }
            $log = ceil(log($range, 2));
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd >= $range);
            return $min + $rnd;
        }

        public function clearAuthCookie() {
            if (get_cookie("member_login") !== NULL) {
                delete_cookie('member_login');
            }
            if (get_cookie("random_password") !== NULL) {
                delete_cookie('random_password');
            }
            if (get_cookie("random_selector") !== NULL) {
                delete_cookie('random_selector');
            }
        }
        
	}