<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">



<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
<title>Untitled Document</title>
</head>

<body>

<div class="container">
    <div class="row">
    <div class="col-md-2">
    </div>
    
    
        <div class="col-md-8">
           
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <div class="card border-secondary">
                        <div class="card-header">
                            <h3 class="mb-0 my-2">FormSent</h3>
                        </div>
                        <div class="card-body">
                            <form action="sent_mail.php" method="post" enctype="multipart/form-data" class="form" role="form" autocomplete="off">
                            <div class="form-group">
                              <label for="" class="font5">To : E-mail</label>
                                    <input name="strTo" type="text" required="" class="form-control font5" id="inputName" placeholder="fordev22@gmail.com, fordev22@hotmail.com">
                                </div>
                                <div class="form-group">
                                    <label for="" class="font5">Subject</label>
                                    <input name="strSubject" type="text" required="" class="form-control font5" id="inputName" placeholder="Subject" value="ตอบกลับการขอรหัสเข้าระบบเบิกจ่ายสวัสดิการ">
                              </div>
                                
                              <div class="form-group">
                                <label for="" class="font5">Header</label>
                                  <input name="strHeader" type="text" required="" class="form-control font5" id="inputEmail3" placeholder="Header" value="ข้อมูล Username และ Password สำหรับเข้าใช้งาน">
                              </div>
                              <div class="form-group">
                                  
                                <label for="exampleFormControlTextarea1">Message</label>
    <textarea name="strMessage" rows="7" class="form-control" id="exampleFormControlTextarea1" placeholder="Message">
ผู้ใช้คนที่ 1
user = s
pass = 

ผู้ใช้คนที่ 2
user = s
pass = 

***กรุณาบันทึกข้อมูลไว้ให้เรียบร้อย

***กรุณาอย่าเปลี่ยนแปลงรหัสอีก 

*** หากเข้าไม่ได้แปลว่า โรงเรียนท่านถูกระงับสิท กรุณาติดต่อ กลุ่มงาน 3%  
    </textarea>
                              </div>
                              
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-xs btn-block">SentMail</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
            </div>
            <!--/row-->

        </div>
        <!--/col-->
    </div>
    <!--/row-->
    
    
    
    
     <div class="col-md-2">
    </div>
    
    
    
    
    
    
</div>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
</body>
</html>