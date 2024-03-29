<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
<script type='text/javascript' src='scripts/fg_ajax.js'></script>
<script type='text/javascript' src='scripts/fg_moveable_popup.js'></script>
<script type='text/javascript' src='scripts/fg_form_submitter.js'></script>

<div id='fg_formContainer'>
	
		  <div id="fg_container_header">
		      <div id="fg_box_Title">Add Class</div>
		      <div id="fg_box_Close"><a href="javascript:fg_hideform('fg_formContainer','fg_backgroundpopup');">Close(X)</a></div>
		  </div>

    	<div id="fg_form_InnerContainer">
	    <form id='contactus' action='javascript:fg_submit_form()' method='post' accept-charset='UTF-8'>
	
	    <input type='hidden' name='submitted' id='submitted' value='1'/>
	    <input type='hidden' name='<?php echo $formproc->GetFormIDInputName(); ?>' value='<?php echo $formproc->GetFormIDInputValue(); ?>'/>
	    <input type='text'  class='spmhidip' name='<?php echo $formproc->GetSpamTrapInputName(); ?>' />
	    
	    <div class='short_explanation'>* required fields</div>
	    
	    <div class='container'>
	        <label for='title' >Course Title*: </label><br/>
	        <input type='text' name='title' id='title' value='' maxlength="255" /><br/>
	    </div>
	    
	    <div class='container'>
	    <label for='dept' >Department*:</label><br/>
	        <input type='text' name='dept' id='dept' value='' maxlength="100" /><br/>
	    </div>
	    
	    <div class='container'>
	    <label for='number' >Course Number*:</label><br/>
	        <input type='text' name='num' id='num' value='' maxlength="100" /><br/>
	    </div>
	    
	    <div class='container'>
	    <label for='number' >Section Number*:</label><br/>
	        <input type='text' name='sec' id='sec' value='' maxlength="100" /><br/>
	    </div>
	    
	    <div class='container'>
	    <label for='text' >Prerequisites:</label><br/>
	        <input type='text' name='pre' id='pre' value='' maxlength="100" /><br/>
	    </div>
	    
	    
	    <div class='container'>
	        <input type='submit' name='Submit' value='Submit' />
	    </div>
	    
		</form>
	</div>
</div>

<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[

    var frmvalidator  = new Validator("contactus");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();
    
    frmvalidator.addValidation("title","req","Please provide a title for this course.");
    frmvalidator.addValidation("dept","req","Please provide a department for this course.");
    frmvalidator.addValidation("num","req","Please provide a course number for this course.");
    frmvalidator.addValidation("sec","req","Please provide a section number for this course.");
	 	frmvalidator.addValidation("pre","","");    

    document.forms['contactus'].refresh_container=function()
    {
        var formpopup = document.getElementById('fg_formContainer');
        var innerdiv = document.getElementById('fg_form_InnerContainer');
        var b = innerdiv.offsetHeight+30+30;

        formpopup.style.height = b+"px";
    }

    document.forms['contactus'].form_val_onsubmit = document.forms['contactus'].onsubmit;
    document.forms['contactus'].onsubmit=function()
    {
        if(!this.form_val_onsubmit())
        {
            this.refresh_container();
            return false;
        }

        return true;
    }
    function fg_submit_form()
    {
        var formobj = document.forms['contactus']

        var submitter = new FG_FormSubmitter("popup-contactform.php",containerobj,sourceobj,error_div,formobj);
        var frm = document.forms['contactus'];
				document.write(document.contactus.title);
        submitter.submit_form(frm);
    }

// ]]>
</script>

<div id='fg_backgroundpopup'></div>

<div id='fg_submit_success_message'>
    <h2>Thanks!</h2>
    <p>
    Thanks for contacting us. We will get in touch with you soon!
    <p>
        <a href="javascript:fg_hideform('fg_formContainer','fg_backgroundpopup');">Close this window</a>
    <p>
    </p>
</div>
