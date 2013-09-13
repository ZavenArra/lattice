<?if ($errors):?>
<ul>
<?foreach($errors as $field=>$error):?>
  <li class="<?=$field;?>" ><?=$error;?></li>
<?endforeach;?>
</ul>
<?endif;?>

<form action="<?=url::base('http')?>registration/create" method="POST" accept-charset="utf-8">

    <h2>Register</h2>

    <label for="reg_username">
    User Name
    <input type="text" name="username" id="reg_username" value="<?echo  isset($username) ? $username : '';?>"  />
    </label>

    <label for="reg_password">
    Password
    <input type="text" name="password" id="reg_password" value="<?echo isset($password) ? $password : '';?>" />
    </label>


    <label for="reg_passwordconfirm">
    Confirm Password
    <input type="text" name="passwordconfirm" id="reg_passwordconfirm" value="<?echo isset($passwordconfirm) ? $passwordconfirm : '';?>" />
    </label>

    <label for="reg_firstname">
    First Name
    <input type="text" name="firstname" id="reg_firstname" value="<?echo isset($firstname) ? $firstname : '';?>" />
    </label>


    <label for="reg_lastname">
    Last Name
    <input type="text" name="lastname" id="reg_lastname" value="<?echo isset($lastname) ? $lastname : '';?>"  />
    </label>


    <label for="reg_email">
    Email 
    <input type="text" name="email" id="reg_email" value="<?echo isset($email) ? $email : '';?>" />
    </label>


    <label for="reg_usertype">
    	Type of user
    	<select name="usertype" id="reg_usertype">
    		<option value="0">Select a user</option>
    		<option value="1">A value</option>
    		<option value="2">A value</option>
    		<option value="3">A value</option>
    	</select>
    </label>

    <input type="submit" value="Continue &rarr;">

</form>
