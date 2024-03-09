<?php
#[\AllowDynamicProperties]
class My_Security extends CI_Security {
    /**
     * Verify Cross Site Request Forgery Protection
     *
     * @return  object
     */
    public function csrf_verify()
    {
        // If it's not a POST request we will set the CSRF cookie
        if (strtoupper($_SERVER['REQUEST_METHOD']) !== 'POST')
        {
			return $this->csrf_set_cookie();
        }

        // Do the tokens exist in both the _POST and _COOKIE arrays?
        if ( ! isset($_POST[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name])) {
            // No token found in $_POST - checking JSON data
            $input_data = json_decode(trim(file_get_contents('php://input')), true);
            if ((!$input_data || !isset($input_data[$this->_csrf_token_name], $_COOKIE[$this->_csrf_cookie_name])))
                $this->csrf_show_error(); // Nothing found
            else {
                // Do the tokens match?
                if ($input_data[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_cookie_name])
                    $this->csrf_show_error();
            }
        }
        else {
            // Do the tokens match?
            if ($_POST[$this->_csrf_token_name] != $_COOKIE[$this->_csrf_cookie_name])
                $this->csrf_show_error();
        }        // We kill this since we're done and we don't want to

        // polute the _POST array
        unset($_POST[$this->_csrf_token_name]);

        // Nothing should last forever
        unset($_COOKIE[$this->_csrf_cookie_name]);
        $this->_csrf_set_hash();
        $this->csrf_set_cookie();

        log_message('debug', 'CSRF token verified');

        return $this;
    }

}
?>
