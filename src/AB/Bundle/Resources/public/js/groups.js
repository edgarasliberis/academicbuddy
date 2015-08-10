$(function() {
	$('select').select2();
});

var GroupApp = function() {
	// Constructor
}

GroupApp.prototype.showError = function(msg) {
	alert(msg);
}

var app = new GroupApp();
$(document).ajaxError(app.showError);

var ApiComms = function() {
	this.updateCsrfToken();
}

ApiComms.prototype.updateCsrfToken = function() {
	var self = this;
	$.get(Routing.generate("groups_token"), function(data) {
		self.csrfToken = data;
	});
}

ApiComms.prototype.listGroups = function(groupCallback) {
	$.get(Routing.generate("groups_list"), function(data) {
		groupCallback(data);
	});
}

ApiComms.prototype.createGroup = function(groupCallback) {
	$.ajax({
		url: Routing.generate("groups_create"),
		type: 'POST',
		headers: { "X-CSRF-Token":  this.csrfToken },
		dataType: "text",
		success: function(data) {
			groupCallback(parseInt(data));
		} 
	});
}
