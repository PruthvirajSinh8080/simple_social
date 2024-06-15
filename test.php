if ($ac_status === -1) {
                $error = array("type" => "error", "errId" => "user_banned", "errMsg" => "Sorry But This User Account Is Banned And Can Not Use Our Site Anymore.", "redirect" => "signup");
                echo json_encode($error);
                exit();
            } else if ($ac_status === 0) {
                $error = array("type" => "error", "errId" => "email_verification_panding", "errMsg" => "Please Verify your Email First.", "redirect" => "email_verification");
                echo json_encode($error);
            } else 