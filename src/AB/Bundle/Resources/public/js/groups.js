$(function() {
    $('select').select2();
});

/** API Comms **/
var ApiComms = function() {
    this.updateCsrfToken();
}

ApiComms.prototype.updateCsrfToken = function() {
    var self = this;
    $.get(Routing.generate("groups_token"), function(data) {
        self.csrfToken = data;
    });
}

ApiComms.prototype.listGroups = function(onSuccess) {
    $.getJSON(Routing.generate("groups_list"), function(data) {
        onSuccess(data);
    });
}

ApiComms.prototype.createGroup = function(onSuccess) {
    $.ajax({
        url: Routing.generate("groups_create"),
        type: 'POST',
        headers: { "X-CSRF-Token":  this.csrfToken },
        dataType: "text",
        success: function(data) {
            onSuccess(parseInt(data));
        } 
    });
}

ApiComms.prototype.deleteAllGroups = function(onSuccess) {
    $.ajax({
        url: Routing.generate("groups_delete_all"),
        type: 'DELETE',
        headers: { "X-CSRF-Token":  this.csrfToken },
        dataType: "text",
        success: function(data) {
            onSuccess(); // No response on success
        } 
    });
}

ApiComms.prototype.listUsers = function(onSuccess) {
    $.getJSON(Routing.generate("groups_users"), function(data) {
        onSuccess(data);
    });
}

ApiComms.prototype.getGroup = function(id, onSuccess) {
    $.getJSON(Routing.generate("groups_get", { "id" : id }), function(data) {
        onSuccess(data);
    });
}

ApiComms.prototype.deleteGroup = function(id, onSuccess) {
    $.ajax({
        url: Routing.generate("groups_delete", { "id" : id }),
        type: 'DELETE',
        headers: { "X-CSRF-Token":  this.csrfToken },
        dataType: "text",
        success: function(data) {
            onSuccess(); // No response on success
        } 
    });
}

ApiComms.prototype.updateGroup = function(id, group, onSuccess) {
    $.ajax({
        url: Routing.generate("groups_delete", { "id" : id }),
        type: 'PUT',
        headers: { "X-CSRF-Token":  this.csrfToken },
        dataType: "json",
        data: group,
        success: function(data) {
            onSuccess(); // No response on success
        } 
    });
}

/** Main JS application **/
var GroupApp = function() {
    var self = this;
    this.comms = new ApiComms();

    // We assume users don't change during the grouping process
    this.comms.listUsers(function (users) {
        self.pupils = users["pupils"];
        self.mentors = users["mentors"];
    });

    this.comms.listGroups(self.loadGroups.bind(self));
}

GroupApp.prototype.showError = function(msg) {
    console.error(msg);
}

GroupApp.prototype.loadGroups = function(groupObj) {
    var self = this;
    self.groups = groupObj.groups;
    Object.keys(groupObj.groups).forEach(function (id) {
        var group = groupObj.groups[id];
        console.info("Setting up card for group #" + id + " with mentor " + (group.mentor? group.mentor.email : "(unknown)"));
        self.displayGroup(id, group);
    });
};

GroupApp.prototype.deleteAllGroups = function() {
    var self = this;
    self.comms.deleteAllGroups(function() {
        $(".group-card-wrapper").delete();
        self.groups = [];
    });
}

GroupApp.prototype.deleteGroup = function() {

}

GroupApp.prototype.displayGroup = function(id, group) {
    var self = this;

    // Add group html
    var groupHtml = '\
    <div id="group-card-{id}" data-id="{id}" class="group-card-wrapper col-sm-4 col-md-3">
      <div class="group-card panel-shadow"> \
        <h3>Grupė #{id}</h3> \
        <div class="form-group"> \
          <label for="select-mentor-{id}">Mentorius</label> \
          <select class="form-control" id="select-mentor-{id}"> \
          </select> \
        </div> \
        <div class="form-group"> \
          <label for="select-secondary-mentor-{id}">Pagalbinis mentorius</label> \
          <select class="form-control" id="select-secondary-mentor-{id}"> \
          </select> \
        </div> \
        <div class="form-group"> \
          <label for="select-pupils-{id}">Mokiniai</label> \
          <select class="form-control" id="select-pupils-{id}" multiple="multiple"> \
          </select> \
        </div> \
        <div class="form-group"> \
          <button type="button" class="btn btn-success form-control"> \
            <span class="glyphicon glyphicon-ok"></span> Išsaugoti \
          </button> \
          <button type="button" class="btn btn-danger form-control"> \
            <span class="glyphicon glyphicon-remove"></span> Pašalinti \
          </button> \
        </div> \
      </div> \
    </div>'.replace(/{id}/g, id);
    $("#groups-container").append(groupHtml);

    // Set up select values
    var $mentorSelect = $("#select-mentor-" + id), $secMentorSelect = $("#select-secondary-mentor-" + id);
    self.mentors.forEach(function (mentor) {
        var optionStr = '<option {selected} data-id={id}>{name}</option>'
            .replace(/{id}/g, mentor.id)
            .replace(/{name}/g, mentor.name);
        $mentorSelect.append(optionStr
            .replace(/{selected}/g, group.mentor !== undefined && mentor.id == group.mentor.id? "selected" : ""));
        $secMentorSelect.append(optionStr
            .replace(/{selected}/g, group.secondaryMentor !== undefined && mentor.id == group.secondaryMentor.id? "selected" : ""));
        
    });

    var $pupilSelect = $("#select-pupils-" + id);
    var pupilIds = group.pupils.map(function(p) { return p.id; });
    self.pupils.forEach(function (pupil) {
        var optionStr = '<option {selected} data-id={id}>{name}</option>'
            .replace(/{id}/g, pupil.id)
            .replace(/{name}/g, pupil.name)
            .replace(/{selected}/g, pupilIds.indexOf(pupil.id) != -1? "selected" : "");
        $pupilSelect.append(optionStr);
    });

    $('#group-card-'+id+' select').select2();

    // Set up button callbacks
    
}

var app = new GroupApp();
$(document).ajaxError(function (err) {
    app.showError(err); 
});