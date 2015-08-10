$(function(){$("select").select2()});var GroupApp=function(){};GroupApp.prototype.showError=function(msg){alert(msg)};var app=new GroupApp;$(document).ajaxError(app.showError);var ApiComms=function(){this.updateCsrfToken()};ApiComms.prototype.updateCsrfToken=function(){var self=this;$.get(Routing.generate("groups_token"),function(data){self.csrfToken=data})};ApiComms.prototype.listGroups=function(groupCallback){$.get(Routing.generate("groups_list"),function(data){groupCallback(data)})};ApiComms.prototype.createGroup=function(groupCallback){$.ajax({url:Routing.generate("groups_create"),type:"POST",headers:{"X-CSRF-Token":this.csrfToken},dataType:"text",success:function(data){groupCallback(parseInt(data))}})};
jQuery(document).ready(function(){$("select.category-select").on("change",function(){$url=Routing.generate("mentor_list",{category:this.value},true);window.location.href=$url});$("div.show").on("click",function(){var button=$(this);var descr=$(this).parent().parent().find(".extended");descr.slideToggle(100,function(){if(descr.is(":visible"))button.html("Mažiau");else button.html("Daugiau")})})});
jQuery(document).ready(function(){$("select.category-select").on("change",function(){$url=Routing.generate("pupil_list",{category:this.value},true);window.location.href=$url});$("div.show").on("click",function(){var button=$(this);var descr=$(this).parent().parent().find(".extended");descr.slideToggle(100,function(){if(descr.is(":visible"))button.html("Mažiau");else button.html("Daugiau")})})});
var collectionHolder=$("ul.courses");var $addCourseLink=$('<p><button type="button" class="btn btn-default btn-sm"><span class="add_course_link glyphicon glyphicon-plus"></span> Pridėti universitetą</button></p>');var $newLinkLi=$("<li></li>").append($addCourseLink);jQuery(document).ready(function(){$("[name$='][university]']").map(function(idx,select){var $select=$(select);addBlankChoice($select);$select.chosen({no_results_text:"Nerasta"})});collectionHolder.data("index",collectionHolder.find(":input").length);collectionHolder.append($newLinkLi);$addCourseLink.on("click",function(e){e.preventDefault();addCourseForm(collectionHolder,$newLinkLi)})});function addCourseForm(collectionHolder,$newLinkLi){var prototype=collectionHolder.data("prototype");var index=collectionHolder.data("index");var newForm=prototype.replace(/__name__/g,index);collectionHolder.data("index",index+1);var $newFormLi=$("<li></li>").append(newForm);$newLinkLi.before($newFormLi);addCourseFormDeleteLink($newFormLi);var $selectUniversity=$("#fos_user_registration_form_courses_"+index+"_university");addBlankChoice($selectUniversity);$selectUniversity.chosen({no_results_text:"Nerasta"})}function addCourseFormDeleteLink($courseFormLi){var $removeFormA=$('<p><button type="button" class="btn btn-default btn-sm"><span class="remove_course_link glyphicon glyphicon-minus"></span> Ištrinti universitetą</button></p>');$courseFormLi.append($removeFormA);$removeFormA.on("click",function(e){e.preventDefault();$courseFormLi.remove()})}function addBlankChoice($selectContainer){$selectContainer.prepend('<option value="">Pasirinkite universitetą:</option>');for(var opt=0;opt<$selectContainer[0].options.length;++opt){if($selectContainer[0].options[opt].hasAttribute("selected"))return}$selectContainer[0].options[0].selected=true}
jQuery(document).ready(function(){function userTypeFromFlags(mentors,pupils){if(mentors&&pupils)return"all";if(mentors)return"mentors";if(pupils)return"pupils";return null}function statusFromFlags(enabled,notEnabled){if(enabled&&notEnabled)return"all";if(enabled)return"enabled";if(notEnabled)return"disabled";return null}$("#inform-applicants").on("click",function(){});$("#export-csv").on("click",function(){var userType=userTypeFromFlags($("#mentors").is(".active"),$("#pupils").is(".active"));var status=statusFromFlags($("#enabled").is(".active"),$("#notenabled").is(".active"));if(!userType||!status)return;var data={usertype:userType,status:status,type:"csv"};window.location=Routing.generate("user_data")+"?"+$.param(data)});$("input").change(function(obj){var label=$(obj.target.labels[0]);label.toggleClass("active");var userType=userTypeFromFlags($("#mentors").is(".active"),$("#pupils").is(".active"));var status=statusFromFlags($("#enabled").is(".active"),$("#notenabled").is(".active"));var data={usertype:userType,status:status,type:"email"};$("#export-csv").prop("disabled",!($("#mentors").is(".active")^$("#pupils").is(".active")));label.toggleClass("active");if(!userType||!status)return;$.get(Routing.generate("user_data"),data).done(function(resp){$("#list").html(resp)})});$("#mentors").click();$("#enabled").click()});