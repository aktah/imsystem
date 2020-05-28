<?php
	class AuthCookie_model extends CI_Model{
		public function isLoggedIn() {
            // วันที่ปัจจุบัน
            $current_time = time();
            $current_date = date("Y-m-d H:i:s", $current_time);

            // ตั้งวันหมดอายุไว้ 1 เดือน
            $cookie_expiration_time = $current_time + (30 * 24 * 60 * 60);

            if ($this->session->userdata('member_id') !== NULL) {
                return true;
            }
            else if (get_cookie("member_login") !== NULL && get_cookie("random_password") !== NULL && get_cookie("random_selector") !== NULL) {

                $isPasswordVerified = false;
                $isSelectorVerified = false;
                $isExpiryDateVerified = false;
                
                $userToken = $this->auth_model->getTokenByUsername(get_cookie("member_login"),false);
                
                if (password_verify(get_cookie("random_password"), $userToken["password_hash"])) {
                    $isPasswordVerified = true;
                }
                
                if (password_verify(get_cookie("random_selector"), $userToken["selector_hash"])) {
                    $isSelectorVerified = true;
                }
                
                if($userToken["expiry_date"] >= $current_date) {
                    $isExpiryDareVerified = true;
                }
                
                if (!empty($userToken["id"]) && $isPasswordVerified && $isSelectorVerified && $isExpiryDareVerified) {
                    $this->session->set_userdata(array("member_id" => $this->user_model->getUserIDByName(get_cookie("member_login"))));
                    return true;
                } else {
                    if(!empty($userToken["id"])) {
                        $this->auth_model->markAsExpired($userToken["id"]);
                    }
                    $this->util_model->clearAuthCookie();
                }
            }
            return false;
		}

		
	}