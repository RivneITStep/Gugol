<head>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
.note
{
    text-align: center;
    height: 80px;
    background: -webkit-linear-gradient(left, #0072ff, #8811c5);
    color: #fff;
    font-weight: bold;
    line-height: 80px;
}
.form-content
{
    padding: 5%;
    border: 1px solid #ced4da;
    margin-bottom: 2%;
}
.form-control{
    border-radius:1.5rem;
}
.btnSubmit
{
    border:none;
    border-radius:1.5rem;
    padding: 1%;
    width: 20%;
    cursor: pointer;
    background: #0062cc;
    color: #fff;
}
</style>
<head>
<div class="container register-form">
            <div class="form">
                <div class="note">
                    <p>UltraCloud</p>
                </div>
				<form action="signup_script.php" method="post">
                <div class="form-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Your Name" value=""/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" placeholder="Email" value=""/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" name="password" placeholder="Your Password" value=""/>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="password_confirm" placeholder="Confirm Password" value=""/>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btnSubmit">Submit</button>
                </div>
				</form>
            </div>
        </div>