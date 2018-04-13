<?php
namespace Course\User;

use \Anax\Database\ActiveRecordModel;

class User extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";
    protected $tableIdColumn = "userID";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $userID;
    public $userFirstName;
    public $userSurName;
    public $userPhone;
    public $userMail;
    public $userGender;
    public $userAddress;
    public $userPostcode;
    public $userCity;
    public $userRole;
    public $userPassword;


    /**
     * Set the password.
     *
     * @param string $password the password to use.
     *
     * @return void
     */
    public function setPassword($password)
    {
        $this->userPassword = password_hash($password, PASSWORD_DEFAULT);
    }



    /**
     * Set role for user. 0 = customer, 1 = admin, 2 = management.
     *
     * @param integer $role the role for user.
     *
     * @return void
     */
    public function setRole($role)
    {
        $this->userRole = $role;
    }



    /**
     * Set city.
     *
     * @param string $city current city for user.
     *
     * @return void
     */
    public function setCity($city)
    {
        $this->userCity = $city;
    }



    /**
     * Set postcode.
     *
     * @param integer $postcode current postcode for user.
     *
     * @return void
     */
    public function setPostcode($postcode)
    {
        $this->userPostcode = $postcode;
    }



    /**
     * Set address.
     *
     * @param string $address current address foruser.
     *
     * @return void
     */
    public function setAddress($address)
    {
        $this->userAddress = $address;
    }



    /**
     * Set gender.
     *
     * @param integer $gender gender
     *
     * @return void
     */
    public function setGender($gender)
    {
        $this->userGender = $gender;
    }



    /**
     * Set email.
     *
     * @param string $email current email for user
     *
     * @return void
     */
    public function setEmail($email)
    {
        $this->userMail = $email;
    }



    /**
     * Set phonenumber.
     *
     * @param string $number current phonenumber for user.
     *
     * @return void
     */
    public function setPhone($number)
    {
        $this->userPhone = $number;
    }



    /**
     * Set surname.
     *
     * @param string $surname current surname.
     *
     * @return void
     */
    public function setSurname($surname)
    {
        $this->userSurName = $surname;
    }



    /**
     * Set firstname.
     *
     * @param string $name current firstname.
     *
     * @return void
     */
    public function setFirstname($name)
    {
        $this->userFirstName = $name;
    }


    /**
     * Get all information about a specific user by email.
     *
     * @param string $email user email.
     *
     * @return \Anax\Database\ActiveRecordModel
     */
    public function getUserInformationByEmail($email)
    {
        $information = $this->find("userMail", $email);
        return $information;
    }



    /**
     * Get all information about a specific user by id.
     *
     * @param integer $userId user id.
     *
     * @return \Anax\Database\ActiveRecordModel
     */
    public function getUserInformationById($userID)
    {
        $information = $this->find("userID", $userID);
        return $information;
    }



    /**
     * Verify the email and the password, if successful the object contains
     * all details from the database row.
     *
     * @param string  $email users email
     * @param string $password the password to use.
     * @return bool true if email and password matches, else false.
     * @internal param string $email email to check.
     */
    public function verifyPassword($email, $password)
    {
        $this->find("userMail", $email);
        return password_verify($password, $this->userPassword);
    }



    /**
     * Fetch permission information by email.
     *
     * @param string $email
     * @return mixed
     */
    public function getPermission($email)
    {
        $userInfo = $this->find("userMail", $email);
        if ($userInfo instanceof User) {
            $permissions = $userInfo->userRole;
            return $permissions;
        }
        return false;
    }



    /**
     * Check if the user exists in the database.
     *
     * @param string $email
     * @return bool true if user exists else false
     */
    public function checkUserExists($email)
    {
        $res = $this->find("userMail", $email);

        if ($res instanceof User) {
            return true;
        }

        return false;
    }


    /**
     * Get all users.
     * @method getAllUsers()
     * @return array with all users.
     */
    public function getAllUsers()
    {
        $res = $this->findAll();
        return $res;
    }
}
