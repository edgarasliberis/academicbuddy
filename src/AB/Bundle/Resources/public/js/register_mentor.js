// Get the ul that holds the collection of courses
var collectionHolder = $('ul.courses');

// setup an "add a course" link
var $addCourseLink = $('<p><button type="button" class="btn btn-default btn-sm"><span class="add_course_link glyphicon glyphicon-plus"></span> Pridėti universitetą</button></p>');
var $newLinkLi = $('<li></li>').append($addCourseLink);
  
jQuery(document).ready(function() {
	
	addBlankChoice($("[name$='[courses][0][university]']"));
	$("[name$='[courses][0][university]']").chosen(
		{no_results_text: "Nerasta"}
	); 

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    collectionHolder.data('index', collectionHolder.find(':input').length);

    // add the "add a course" anchor and li to the courses ul
    collectionHolder.append($newLinkLi);

    $addCourseLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new course form (see next code block)
        addCourseForm(collectionHolder, $newLinkLi);
    });
});

function addCourseForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = collectionHolder.data('prototype');

    // get the new index
    var index = collectionHolder.data('index');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    var newForm = prototype.replace(/__name__/g, index);

    // increase the index with one for the next item
    collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a course" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addCourseFormDeleteLink($newFormLi);

    var $selectUniversity = $("#mentor_registration_mentor_courses_" + index + "_university");
    addBlankChoice($selectUniversity);
    $selectUniversity.chosen(
		{no_results_text: "Nerasta"}
	); 
}

function addCourseFormDeleteLink($courseFormLi) {
    var $removeFormA = $('<p><button type="button" class="btn btn-default btn-sm"><span class="remove_course_link glyphicon glyphicon-minus"></span> Ištrinti universitetą</button></p>');
    $courseFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the course form
        $courseFormLi.remove();
    });
}

function addBlankChoice($selectContainer) {
	$selectContainer.prepend('<option value="">Pasirinkite universitetą:</option>');
	$selectContainer[0].options[0].selected = true;	

}