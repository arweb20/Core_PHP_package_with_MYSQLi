<?php

namespace Api\Models;

use Api\Models\DB as Connection;

class User
{

    private $connObj = null;

    public function __construct()
    {
        $this->connObj = new Connection();
    }

    /* ******************************** DUPLICATE MOBILE NUMBER ******************************** */

    public function getDupMobile($datas = null)
    {
        $getjsonData = json_decode($datas);
        $mobileno = $getjsonData->mobile_no;
        $hmobileno = $getjsonData->hmobile_no;

        $sql = "SELECT * FROM bio_data WHERE mobile = ? AND mobile != ?";
        $stmt = $this->connObj->getConnection()->prepare($sql);
        $stmt->bind_param("ii", $mobileno, $hmobileno);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        $stmt->free_result();
        $retData = array("Record" => $numRows);
        return $retData;
    }

    /* ******************************** DUPLICATE MOBILE NUMBER ******************************** */

    /* ******************************** DUPLICATE EMAIL ID ******************************** */

    public function getDupEmail($datas = null)
    {
        $getjsonData = json_decode($datas);
        $email = $getjsonData->email_id;
        $hemail = $getjsonData->hemail_id;

        $sql = "SELECT * FROM bio_data WHERE email = ? AND email != ?";
        $stmt = $this->connObj->getConnection()->prepare($sql);
        $stmt->bind_param("ss", $email, $hemail);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        $stmt->free_result();
        $retData = array("Record" => $numRows);
        return $retData;
    }

    /* ******************************** DUPLICATE EMAIL ID ******************************** */

    /* ******************************** INSERT BIO-DATA ******************************** */

    public function createUser($datas = null)
    {
        $insertSQL = "";

        $getjsonData = json_decode($datas);
        $id = $getjsonData->UserID;
        $regName = $getjsonData->RegName;
        $courseName = $getjsonData->CourseName;
        $gender = $getjsonData->Gender;
        $email = $getjsonData->Email;
        $mobile = $getjsonData->Mobile;
        $website = $getjsonData->Website;
        $about = $getjsonData->About;
        $languages = $getjsonData->Languages;
        $profileImage = $getjsonData->ProfileImage;
        $profileImageType = $getjsonData->ProfileImageType;
        $profileIDCard = $getjsonData->ProfileID;
        $certificateImage = $getjsonData->CertificateImage;
        $certificateImageType = $getjsonData->CertificateImageType;

        $insertSQL = "INSERT INTO bio_data VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->connObj->getConnection()->prepare($insertSQL);
        $stmt->bind_param("isssisssssssss", $id, $regName, $courseName, $email, $mobile, $website, $gender, $languages, 
                            $about, $profileImage, $profileImageType, $certificateImage, $certificateImageType,
                            $profileIDCard);
        $retVal = $stmt->execute();
        if ($retVal == true) {
            $retValue = 1;
        } else {
            $retValue = 0;
        }
        return $retValue;
    }

    /* ******************************** INSERT BIO-DATA ******************************** */

    /* ******************************** SELECTED BIO-DATA DETAILS ******************************** */

    public function getSelectedUser($datas = null)
    {
        $sql = "";
        $getjsonData = json_decode($datas);
        $userID = $getjsonData->UserID;

        $sql = "SELECT * FROM bio_data WHERE user_id=?";
        $stmt = $this->connObj->getConnection()->prepare($sql);
        $stmt->bind_param('i', $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->free_result();
        $retData = array("Record" => $numRows, "Data" => $data);
        return $retData;
    }

    /* ******************************** SELECTED BIO-DATA DETAILS ******************************** */

    /*     * ******************************* BIO-DATA DETAILS *********************************/

    public function getAllUsers($datas = null)
    {
        $limit = "";
        if($datas != null){
            $getjsonData = json_decode($datas);
            $startIndex = $getjsonData->StartIndex;
            $records = $getjsonData->RecordsToBeShown;
    
            if (($startIndex != "") && ($records != "")) {
                $limit = "LIMIT $startIndex, $records";
            } else {
                $limit = "";
            }
        }
        
        $sql = "SELECT * FROM bio_data ORDER BY full_name " . $limit;
        $stmt = $this->connObj->getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $numRows = $result->num_rows;
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $stmt->free_result();
        $retData = array("Record" => $numRows, "Data" => $data);
        return $retData;
    }

    /*     * ******************************* BIO-DATA DETAILS ******************************** */

    /*     * ******************************* BIO-DATA UPDATE ******************************** */

    public function updateUser($datas = null)
    {
        $sql = "";
        $getjsonData = json_decode($datas);
        $id = $getjsonData->UserID;
        $regName = $getjsonData->RegName;
        $courseName = $getjsonData->CourseName;
        $gender = $getjsonData->Gender;
        $email = $getjsonData->Email;
        $mobile = $getjsonData->Mobile;
        $website = $getjsonData->Website;
        $about = $getjsonData->About;
        $languages = $getjsonData->Languages;
        $profileImage = $getjsonData->ProfileImage;
        $profileImageType = $getjsonData->ProfileImageType;
        $profileIDCard = $getjsonData->ProfileID;
        $certificateImage = $getjsonData->CertificateImage;
        $certificateImageType = $getjsonData->CertificateImageType;

        $sql .= "UPDATE bio_data SET full_name=?, course_name=?, gender=?, languages=?, mobile=?, ";
        $sql .= "email=?, website=?, about=?, profile_pic=?, profile_pic_type=?, id_card=?, ";
        $sql .= "certificate_image=?, certificate_image_type=? WHERE user_id=?";
        $stmt = $this->connObj->getConnection()->prepare($sql);

        $stmt->bind_param('ssssissssssssi', $regName, $courseName, $gender, $languages, $mobile,
                             $email, $website, $about, $profileImage, $profileImageType, $profileIDCard,
                             $certificateImage, $certificateImageType, $id);
        $retVal = $stmt->execute();
        if ($retVal == true) {
            $retValue = 1;
        } else {
            $retValue = 0;
        }
        return $retValue;
    }

    /*     * ******************************* BIO-DATA UPDATE ******************************** */

    /*     * ******************************* DELETE BIO-DATA ******************************** */

    public function deleteUser($datas = null)
    {
        $sql = "";
        $getjsonData = json_decode($datas);
        $userID = $getjsonData->UserID;
        $sql = "DELETE FROM bio_data WHERE user_id=?";
        $stmt = $this->connObj->getConnection()->prepare($sql);
        $stmt->bind_param('i', $userID);
        $retVal = $stmt->execute();

        if ($retVal == true) {
            $retValue = 1;
        } else {
            $retValue = 0;
        }
        return $retValue;
    }

    /*     * ******************************* DELETE BIO-DATA ******************************** */
}