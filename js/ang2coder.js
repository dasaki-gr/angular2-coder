editor = new Object();
var changed = false;
function changeTrue() {
  changed = true;
}

function changeReset() {
  changed = false;
}

function hasChanged() {
  return changed;
}

function checkChanged() {
  if(hasChanged()) {
    if(confirm('You have unsaved changes on this page. Are you sure you want to load a new document?')) {
      changed = false;
    }
    else {
      changed = true;
    }
  }
  return changed;
}


(function($){
	$(document).ready(function(){

    // delete .hidden style from bootstrap.min.css because of bug see page:
    // https://wordpress.org/support/topic/wp-admincss-classhidden-bug-renders-screen-options-menu-in-admin-blank
    deleteRuleInSheet('admin_css_bootstrap-css','.hidden');

    // var now = moment().format("dddd, MMMM Do, YYYY, h:mm:ss A");
     // Saturday, June 9th, 2007, 5:46:21 PM
    $('#date').append('now');
    //var switcherButton = $( "form input:checkbox" )
    $( "form input:checkbox" ).change(function(){
      if ($(this).val() == "1") {
        $(this).val("0");
      }
      else {
        $(this).val("1");
      }

    })
		$('#new-content').change(function() {
			changeTrue();
		});

		$('#save-result').click(function() {
			$(this).show();
		});
		$('.ajax-settings-form').submit(function() {
			var data = getFormData($(this).attr('id'));
      // console.log('pressed ajax-settings-form');
			$.ajax({
					type: "POST",
					url: ajaxurl,
					data: data,
					dataType: 'json',
					success: function(result) {
						$('#save-result').html("<div id='save-message' class='" + result[0] + "'></div>");
						$('#save-message').append(result[1]);
						$('#save-result').fadeIn(1000).delay(3000).fadeOut(300);
					}
			});
			return false;
		});

	});

  // delete a rule in a Style Sheet
  // informations from pages: http://stackoverflow.com/questions/12753700/get-stylesheet-rule-javascript-jquery
  function deleteRuleInSheet(mysheetID, ruleName){
    var mysheet = $('link#'+mysheetID)[0].sheet;

    //console.log(mysheet);
    var getRule = ruleName;
    var deleteIndex = -1;
    var rules=mysheet.cssRules;
            for(var j=0, l2=rules.length; j<l2; j++){
                var rule=rules[j];
                //console.log(' ....... j='+j+',  '+rule.selectorText);
                // SELECT APPROPRIATE RULE IN STYLESHEET
                if(getRule === rule.selectorText){
                    //console.log(' ******* j='+j);
                    deleteIndex = j;
                    // LOSE IT HERE

                };
            };
            if(deleteIndex>0) {
              mysheet.deleteRule(deleteIndex);
              console.log(ruleName+' Rule DELETED !!!');
            };
      //mysheet.insertRule(":not(#wpbody) {  .hidden {    display: none! important;    visibility: hidden! important;  }}", 0);
  }


})(jQuery);

function getFormData(formId) {
  console.log('getFormData');
  var vv=0;
	$jq = jQuery.noConflict();
	var theForm = $jq('#' + formId);
  console.log("getFormData:"+'#' + formId);
	var str = '';
	// $jq('input:not([type=checkbox], :radio), input[type=checkbox]:checked, input:radio:checked, select, textarea', theForm).each(
  $jq('input:not([type=checkbox], :radio), input[type=checkbox], select, textarea', theForm).each(
		function() {

      vv++;
			var name = $jq(this).attr('name');
			var val = encodeURIComponent($jq(this).val());
      console.log(vv+name+', '+val);
			str += name + '=' + val + '&';
		}
	);
  console.log('data='+str.substring(0, str.length-1));
	return str.substring(0, str.length-1);
}
