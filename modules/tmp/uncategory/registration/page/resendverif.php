				<div style="margin-bottom:30px"><?=e_()?></div>
				<form action="/data/registration" method="get">
				    <div class="form-group">
				    	<input class="form-control rounded-left" type="email" name="resend" placeholder="Email" required="">
					</div>
					<div class="form-group">
	    				<button type="submit" class="form-control btn btn-primary rounded submit px-3">RESEND VERIFICATION CODE</button>
					</div>
				</form>
				<a style="color:white" href="/<?=D_PAGE?>?p=verify">VERIFICATION</a>