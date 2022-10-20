				<div style="margin-bottom:30px" class="text-center"><?=e_()?></div>
				<form action="/data/registration" method="get">
                    <div class="form-group">
    					<input class="form-control rounded-left" type="text" name="verify" placeholder="Verification Code" required="">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary rounded submit px-3">VERIFY</button>
                    </div>
				</form>
				<a href="/<?=D_PAGE?>?p=resend">RESEND CODE</a>