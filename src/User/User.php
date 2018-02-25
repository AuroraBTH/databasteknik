<?php
namespace Course\User;

use \Anax\Database\ActiveRecordModel;

class User extends ActiveRecordModel
{

    /**
     * @var string $tableName name of the database table.
     */
    protected $tableName = "User";

    /**
     * Columns in the table.
     *
     * @var integer $id primary key auto incremented.
     */
    public $userId;
    private $userFirstName;
    private $userSurName;
    private $userPhone;
    private $userMail;
    private $userGender;
    private $userAddress;
    private $userPostcode;
    private $userCity;
    private $userRole;
    private $userPassword;


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
           * @return array
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
           * @return array
           */
           public function getUserInformationById($userId)
           {
               $information = $this->find("userID", $userId);
               return $information;
           }
}
