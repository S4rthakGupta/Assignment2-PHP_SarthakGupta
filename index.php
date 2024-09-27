<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- This is the title for the Home page. -->
    <title>Fitness Class</title>
    <!-- Linking the CSS file which is placed in the public folder. -->
    <link rel="stylesheet" href="public/CSS/style.css">
</head>

<!-- Content for the body starts from here. -->
<body>

    <!-- This is the header and the navbar. It is consistent across all pages. -->
    <header class="header">
        <h2 id="nav-title"><span class="h-span">Fit</span>ness Class</h2>
        <nav class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>

                <!-- Creating an extra About Me section to display my details. -->
                <li><a href="about.php">About Me</a></li>
            </ul>
        </nav>
    </header>

    <!-- This is the PHP code below -->
    
    <?php

    // Initializing error variables for each form field. 
    // These will store any error messages to be displayed if the user input is invalid.
    $firstNameErr = $lastNameErr = $dobErr = $emailErr = $phoneErr = $emergencyContactErr = $genderErr = $batchErr = $addressErr = "";
    
    // Initialzing variables to store the input.
    // These will hold the values entered in the form, which can later be validated and processed.
    $firstName = $lastName = $dateOfBirth = $email = $phoneNumber = $emergencyContact = $membershipNumber = $referralSource = $address = $gender = $batch = $medicalConditions = $comment = "";


    // This is a function to sanitize (clean) input data.
    function test_input($data)
    {
        // Remove unnecessary spaces from the beginning and the end of the input.
        $data = trim($data);

        // Remove backlashes from the input.
        $data = stripslashes($data);

        // This below line converts special characters to HTML entities to prevent XSS attacks.
        $data = htmlspecialchars($data);
        return $data;
    }

    // This below if-statement checks if the form has been submitted using the POST method.
    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        // This below is a flag to check if form is valid.
        $isValid = true; 

        // Validating the First Name.
        if (empty($_POST["first_name"])) 
        {           
            // This below line will check if the first name field is empty, and if it is then it will display an error message
            $firstNameErr = "First Name is required";
            $isValid = false;
        } 
        else 
        {
            $firstName = test_input($_POST["first_name"]);
            // This is a pattern which makes sures that only spaces or characters are entered.
            if (!preg_match("/^[a-zA-Z-' ]*$/", $firstName)) 
            {
                $firstNameErr = "Only letters and spaces are allowed";
                $isValid = false;
            }
        }


        // Validating Last Name.
        if (empty($_POST["last_name"])) 
        {
            $lastNameErr = "Last Name is required";
            $isValid = false;
        } 
        else 
        {
            $lastName = test_input($_POST["last_name"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/", $lastName)) 
            {
                $lastNameErr = "Only letters and spaces are allowed";
                $isValid = false;
            }
        }

        // Validate Date of Birth.
        if (empty($_POST["date_of_birth"])) 
        {
            $dobErr = "Date of Birth is required";
            $isValid = false;
        } 
        else 
        {
            $dateOfBirth = test_input($_POST["date_of_birth"]);

            // This is a validation to check if the user is above 18+ years or not.
            $birthDate = new DateTime($dateOfBirth);
            $today = new DateTime();

            // It only displays the years and dates in the calender for users who are 18+, rest all years are disabled.
            $age = $today->diff($birthDate)->y;

            if ($age < 18) 
            {
                $dobErr = "You must be at least 18 years old to register";
                $isValid = false;
            }
        }

        // Validate Email.
        if (empty($_POST["email"])) 
        {
            $emailErr = "Email is required";
            $isValid = false;
        } 
        else 
        {
            $email = test_input($_POST["email"]);
            // This below pattern checks if the email address is valid.
            if (!preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) 
            {
                $emailErr = "Invalid email format";
                $isValid = false;
            }
        }

        // Validate Phone Number.
        if (empty($_POST["phone_number"])) 
        {
            $phoneErr = "Phone Number is required";
            $isValid = false;
        } 
        else 
        {
            $phoneNumber = test_input($_POST["phone_number"]);
            // This pattern checks if the phone number entered by user is correct or not and also checks if digits are more than 10.
            if (!preg_match("/^[0-9]{10}$/", $phoneNumber)) 
            {
                $phoneErr = "Invalid phone number format";
                $isValid = false;
            }
        }

        // Validate Emergency Contact.
        if (empty($_POST["emergency_contact"])) 
        {
            $emergencyContactErr = "Emergency Contact Number is required";
            $isValid = false;
        } 
        else 
        {
            $emergencyContact = test_input($_POST["emergency_contact"]);
            // This is also checking if the phone number entered is in a correct pattern.
            if (!preg_match("/^[0-9]{10}$/", $emergencyContact)) 
            {
                $emergencyContactErr = "Invalid phone number format";
                $isValid = false;
            }
        }

        // Validate Address.
        if (empty($_POST["address"])) 
        {
            $addressErr = "Address is required";
            $isValid = false;
        } 
        else 
        {
            $address = test_input($_POST["address"]);
        }

        // Validate Gender.
        if (empty($_POST["gender"])) 
        {
            $genderErr = "Gender is required";
            $isValid = false;
        } 
        else 
        {
            $gender = test_input($_POST["gender"]);
        }

        // Validate Batch.
        if (empty($_POST["batch"])) 
        {
            $batchErr = "Please choose a batch";
            $isValid = false;
        } 
        else 
        {
            $batch = test_input($_POST["batch"]);
        }

        // These are the Optional fields.
        $membershipNumber = test_input($_POST["membership_number"]);
        $referralSource = test_input($_POST["referral_source"]);
        $medicalConditions = test_input($_POST["medical_conditions"]);
        $comment = test_input($_POST["comment"]);

        // Redirects to success.php page if all validations are correct.
        if ($isValid) 
        {
            header("Location: success.php");
            exit();
        }
    }
    ?>


    <!-- The content for the main body starts from here. -->
    <main>

        <!-- This is the div for the home. -->
        <div class="home-main" >
        <h1 class="main-h1">Registration Form</h1>

        <!-- The form element starts here. -->
        <!-- The 'action' attribute uses PHP's 'htmlspecialchars' function to prevent XSS attacks by escaping special characters in the current page's URL. -->
        <form method="POST" class="form-grid" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <div class="form-group">

                <!-- This below is a span which is style with .error in red colour in CSS -->
                 <!-- It echo's the validation error if their is any. -->
                <span class="error">* <?php echo $firstNameErr; ?></span>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo $firstName; ?>">
            </div>

            <div class="form-group">
                <span class="error">* <?php echo $lastNameErr; ?></span>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo $lastName; ?>">
            </div>

            <div class="form-group">
                <span class="error">* <?php echo $dobErr; ?></span>
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo $dateOfBirth; ?>" max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
            </div>

            <div class="form-group">
                <span class="error">* <?php echo $emailErr; ?></span>
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="<?php echo $email; ?>">
            </div>

            <div class="form-group">
                <span class="error">* <?php echo $phoneErr; ?></span>
                <label for="phone_number">Phone Number:</label>
                <input type="tel" id="phone_number" name="phone_number" value="<?php echo $phoneNumber; ?>">
            </div>

            <div class="form-group">
                <span class="error">* <?php echo $emergencyContactErr; ?></span>
                <label for="emergency_contact">Emergency Contact Number:</label>
                <input type="tel" id="emergency_contact" name="emergency_contact" value="<?php echo $emergencyContact; ?>">
            </div>

            <div class="form-group">
                <label for="membership_number">Membership Number (if applicable):</label>
                <input type="text" id="membership_number" name="membership_number" value="<?php echo $membershipNumber; ?>">
            </div>

            <div class="form-group">
                <label for="referral_source">How Did You Hear About Us?</label>
                <input type="text" id="referral_source" name="referral_source" value="<?php echo $referralSource; ?>">
            </div>

            <div class="form-group full-width">
                <span class="error">* <?php echo $addressErr; ?></span>
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="<?php echo $address; ?>">
            </div>

            <div class="form-group full-width">
                <fieldset>
                    <legend>Gender:</legend>
                    <label><input type="radio" id="male" name="gender" value="Male" <?php if ($gender == "Male") echo "checked"; ?>> Male</label>
                    <label><input type="radio" id="female" name="gender" value="Female" <?php if ($gender == "Female") echo "checked"; ?>> Female</label>
                    <label><input type="radio" id="other" name="gender" value="Other" <?php if ($gender == "Other") echo "checked"; ?>> Other</label>
                    <span class="error">* <?php echo $genderErr; ?></span>
                </fieldset>
            </div>

            <div class="form-group full-width">
                <fieldset>
                    <legend>Choose a Batch:</legend>
                    <label><input type="radio" id="slot1" name="batch" value="Slot1" <?php if ($batch == "Slot1") echo "checked"; ?>> Slot 1 (9:00am to 12:00pm)</label>
                    <label><input type="radio" id="slot2" name="batch" value="Slot2" <?php if ($batch == "Slot2") echo "checked"; ?>> Slot 2 (12:00pm to 3:00pm)</label>
                    <label><input type="radio" id="slot3" name="batch" value="Slot3" <?php if ($batch == "Slot3") echo "checked"; ?>> Slot 3 (3:00pm to 6:00pm)</label>
                    <label><input type="radio" id="slot4" name="batch" value="Slot4" <?php if ($batch == "Slot4") echo "checked"; ?>> Slot 4 (6:00pm to 9:00pm)</label>
                    <span class="error">* <?php echo $batchErr; ?></span>
                </fieldset>
            </div>

            <div class="form-group full-width">
                <label for="medical_conditions">Medical Conditions or Allergies:</label>
                <textarea id="medical_conditions" name="medical_conditions" placeholder="Please list any relevant medical conditions or allergies"><?php echo $medicalConditions; ?></textarea>
            </div>

            <div class="form-group full-width">
                <label for="comment">Additional Comments:</label>
                <textarea id="comment" name="comment"><?php echo $comment; ?></textarea>
            </div>

            <div class="form-group full-width">
                <input type="submit" value="Submit">
            </div>
        </form>
        </div>
    </main>
    <!-- Main body ends here. -->

    <!-- This is the footer and is consistent across all pages. -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 Fitness Class by Sarthak Gupta. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>