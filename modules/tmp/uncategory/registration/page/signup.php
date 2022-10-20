				<form action="/registration" method="post" class="login-form">
				    <?php //echo token(); echo 'ok';?>
					<input class="icon" type="text" name="username" placeholder="Username" style="display:none">
				    <div class="form-group">
					    <input class="form-control rounded-left" type="email" name="email" placeholder="Email" required="">
				    </div>
				    <div class="form-group">
					    <input class="form-control rounded-left" type="password" name="password" placeholder="Password" required="">
				    </div>
				    <div class="form-group">
					    <input class="form-control rounded-left" type="password" name="cpassword" placeholder="Confirm Password" required="">
					</div>
					<!--div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span><a href="/terms" style="color:white">I Agree To The Terms & Conditions</a></span>
						</label>
						<div class="clear"> </div>
					</div-->
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">Registrasi</button>
                    </div>
					<!--input type="submit" value="SIGNUP" style="margin-top:-30px"-->
				</form>
				<p style="padding-top:40px">Sudah punya akun? <a href="/login"> Login</a></p>
				<hr>
<? if($igs=='true'){
	echo google_button_signin();
	google_signin_js('coordinate-conversion');
}?>

