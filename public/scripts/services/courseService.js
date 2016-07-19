//this is the heart of application, it is getting data from server and every controller is calling this for data or to talk to server
app.service('courseService', ['$http', '$q', function ($http, $q) {

	var courses;
	//var ROOT_URL = "http://localhost/laravel/l2p/public/";

	var URL_AUTHENTICATE = "authenticate";
	var URL_GET_ALL_COURSES = "courses";
	var URL_GET_COURSE = "course";
	var URL_GET_CURRENTSEM ="current_semester";
    var LOGOUT = "logout";
    var URL_SEMESTER = "/semester";
    var URL_SORTED_SEMESTER = "semesters";
    var URL_GET_LEARNING_MATERIALS = "/all_learning_materials";
    var URL_GET_ASSIGNMENTS = "/all_assignments";

    var URL_VIEW_USER_ROLE = "view_user_role";

	var URL_GET_ALL_EMIALS = "/all_emails";
    var URL_ADD_EMAIL = "/add_email";
	var URL_DELETE_EMAIL = "/delete_email";

	var URL_GET_ALL_ANNOUNS = "/all_announcements";
	var URL_ADD_ANNOUNS = "/add_announcement";
	var URL_DELETE_ANNOUNS = "/delete_announcement";
	var URL_UPDATE_ANNOUNS = "/update_announcement";

	var URL_GET_ALL_DISCUSSIONS = "/all_discussion_items";
	var URL_ADD_DISCUSSION = "/add_discussion_thread";
	var URL_ADD_DISCUSSION_REPLY = "/add_discussion_thread_reply";
	var URL_DELETE_DISCUSSION = "/delete_discussion_item";

	var URL_GET_COURSE_INFO = "/course_info";

	var URL_GET_ALL_COURSE_EVENTS = "all_course_events";

	var URL_GET_ALL_WHATS_NEW = "whats_all_new_since_new";
	var URL_GET_ALL_WHATS_FOR_INBOX = "whats_all_new_since";

	var URL__GET_ALL_SHARED_DOCS = "/all_shared_documents";

	var URL_GET_INBOX = "inbox";
	var URL_INBOX_EMAIL = "/emails";
	var URL_INBOX_ANNOUN = "/announcements";

	var authenticated = true;

	// authenticate user from server whether user is authenticated or not
	this.isUserAuthenticated = function(){
		var defer = $q.defer();

		$http.get(URL_AUTHENTICATE)
		.success(function(res){
			console.log(res.Status);
			defer.resolve(res);
			if(res.Status){
				authenticated = true;
			}
			else{
				authenticated = false;
			}
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	//return if user is authenticated
	this.getAuthenticatedValue = function(){
		return authenticated;
	}

	//get all courses list from server
	this.getAllCourses = function(){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_COURSES)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//get current semester from server
	this.getCurrentSem = function(sem){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE+ URL_SEMESTER+ "/"+sem)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//get sorted list of semester from server
	this.getSortedSems = function(){
		var defer = $q.defer();

		$http.get(URL_SORTED_SEMESTER)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//get list of courses by semester from server
    this.getCourseBySem = function(){
		var defer = $q.defer();

		$http.get()
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	this.getAllCourseEvents = function(){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_COURSE_EVENTS)
		.success(function(res){
			console.log("sucess in course service");
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	//get all whats new by mins from server
	this.getAllWhatsNew = function(mins){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_WHATS_NEW + "/"+ mins)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.getAllWhatsNewForInbox = function(mins){
		var defer = $q.defer();

		$http.get(URL_GET_ALL_WHATS_FOR_INBOX + "/"+ mins)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//get all learning materials by course from server
	this.getAllLearningMaterials = function(cid){
		var defer = $q.defer();
		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_LEARNING_MATERIALS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	//get all shared docs by course from server
	this.getAllSharedDocs = function(cid){
		var defer = $q.defer();
		$http.get(URL_GET_COURSE + "/" + cid + URL__GET_ALL_SHARED_DOCS)
		.success(function(res){
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	//get all assignments by course from server
	this.getAllAssignments = function(cid){
		var defer = $q.defer();
		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_ASSIGNMENTS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	//log out user from server
    this.logout = function(){
        var defer = $q.defer();

		$http.get(LOGOUT)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    //see user whether he/she is student, teacher or manager
    this.viewUserRole = function(cid){
        var defer = $q.defer();

		$http.get(URL_GET_COURSE + "/" + cid+ "/"+ URL_VIEW_USER_ROLE)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

	this.getEmailbyid = function(cid){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_ALL_EMIALS)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

    this.addEmail = function(cid, email){
        var defer = $q.defer();
        var content = URL_GET_COURSE+ "/"+ cid+ URL_ADD_EMAIL;

		$http.post(content, email)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.deleteEmail = function(cid, itemId){
	    var defer = $q.defer();
	    var content = URL_GET_COURSE+ "/"+ cid+ URL_DELETE_EMAIL+ "/"+ itemId;

		$http.get(content)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.getAnnounbyid = function(cid){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE+ "/"+ cid+ URL_GET_ALL_ANNOUNS)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

    this.addAnnoun = function(cid, announcement){
        var defer = $q.defer();
        var content = URL_GET_COURSE+ "/"+ cid+ URL_ADD_ANNOUNS;

		$http.post(content, announcement)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.editAnnoun = function(cid, announcement, itemId){
        var defer = $q.defer();
        var content = URL_GET_COURSE+ "/"+ cid+ URL_UPDATE_ANNOUNS+ "/"+ itemId;

		$http.post(content, announcement)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.deleteAnnoun = function(cid, itemId){
	    var defer = $q.defer();
	    var content = URL_GET_COURSE+ "/"+ cid+ URL_DELETE_ANNOUNS+ "/"+ itemId;

		$http.get(content)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
    }

    this.getAllDiscussions = function(cid){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE+ "/"+ cid+ URL_GET_ALL_DISCUSSIONS)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.addDiscussion = function(cid, discussion){
		var defer = $q.defer();

		$http.post(URL_GET_COURSE+ "/"+ cid+ URL_ADD_DISCUSSION, discussion)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.addDiscussionReply = function(cid, replyToId, discussion){
		var defer = $q.defer();
		var content = URL_GET_COURSE+ "/"+ cid+ URL_ADD_DISCUSSION_REPLY+ "/"+ replyToId;

		$http.post(content, discussion)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.deleteDiscussion = function(cid, selfId){
		var defer = $q.defer();

		$http.get(URL_GET_COURSE+ "/"+ cid+ URL_DELETE_DISCUSSION+ "/"+selfId)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//get single course information from server
    this.getCourseInfo= function(cid){
		var defer = $q.defer();
		$http.get(URL_GET_COURSE + "/" + cid + URL_GET_COURSE_INFO)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	}

	this.getInboxEmails = function(mins){
		var defer = $q.defer();

		$http.get(URL_GET_INBOX+ URL_INBOX_EMAIL+ "/"+ mins)
		.success(function(res){
			//console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	this.getInboxAnnouns = function(mins){
		var defer = $q.defer();

		$http.get(URL_GET_INBOX+ URL_INBOX_ANNOUN+ "/"+ mins)
		.success(function(res){
			// console.log(res);
			defer.resolve(res);
		})
		.error(function(err, status){
			console.log(err);
			defer.reject(err);
		})

		return defer.promise;
	};

	//File uploading related data
	var fileToUpload = null;
	var fileName = null;

	//set file here so it can access from anywhere
	this.setFile = function(name, stream){
		fileName = name;
		fileToUpload = stream;
	}

	//return file stream
	this.getFile = function(){
		return fileToUpload;
	}

	//return file name
	this.getFileName = function(){
		return fileName;
	}

}]);
