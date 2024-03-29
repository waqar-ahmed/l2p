<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <style>
            div {margin-bottom: 10px;}
        </style>
    </head>
    <body>
        <div style="width: 100%">
            <div style="width: 40%; display: inline-block;">
                <div>
                    <labe>uri: </labe>
                    <input type="text" class="" name="uri" size="30" value="/course/{cid}">            
                </div>                
                <div>
                    <label>method: </label>
                    <select name="method">
                        <option value="get">Get</option>
                        <option value="post">Post</option>  
                    </select>
                </div>         
                <div>
                    <h4 style="display: inline">url parameters: </h4>
                    <button onclick="addParam('url_parameters')" id="addParamBtn">Add</button>
                </div>        
                <div id="url_parameters" class="parameters">                    
                </div>

                <div>
                    <h4 style="display: inline">json request parameters: </h4>
                    <button onclick="addParam('json_parameters')" id="addParamBtn">Add</button>            
                </div>        
                <div>
                    <input type="file" id="upload" value="upload"/>
                </div>

                <div id="json_parameters" class="parameters">

                </div>
                <button onclick="send()" id="sendBtn" style="margin-bottom: 10px">Send</button>
                <button onclick="reset()" id="resetBtn" style="margin-bottom: 10px">Reset</button>
                <span id="loadingText" hidden="true">loading...</span>
                <div>
                    <textarea class="result" hidden="true" cols="70" rows="20"></textarea>
                </div>        
                <div id="errorDisplayDiv">  
                    Create folder is not working properly.
                </div>
            </div>
            <div id="routes" style="width: 30%; display: inline-block; vertical-align:top;">                
                Select routes:
                <select name="modules" id="module_select">                    
                </select>
                <br/>
                <br/>
                Sub routes:
                <div id="sub_routes" style="margin-top: 5px;">
                    
                </div>
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    </body>
</html>
<script>
    $(document).ready(function () {
        $(".parameters").on('click', 'a.removeParam', function () {
            $(this).closest('div').remove();
        });
        
        $("#routes").on('click', 'a.route', function() {
            reset(); 
            fillForm($(this).attr('parent'), $(this).attr('value'));
        });
        $(document).on('change', "input[type='text']", function () {
            extendInput(this);
        });
        document.getElementById('upload').addEventListener('change', handleFileSelect, false);
        showUrls();
        authenticate();
    });

    function handleFileSelect(evt) {
        var files = evt.target.files;
        var file = files[0];
        if (files && file) {
            var reader = new FileReader();
            reader.onload = function (e) {
//                var arrayBuffer = new Int8Array(e.target.result);
                var binString = e.target.result;
                var base64 = btoa(binString);
                if (base64) {
                    addParam('json_parameters', 'fileName', file.name);
                    addParam('json_parameters', 'stream', base64);
//                    window.open("data:application/octet-stream;base64," + base64);
                }
            };

//            reader.readAsArrayBuffer(file);            
            reader.readAsBinaryString(file);
        }
    }    

    function uint8ToString(buf) {
        var i, length, out = '';
        for (i = 0, length = buf.length; i < length; i += 1) {
            out += String.fromCharCode(buf[i]);
        }
        return out;
    }

    function addParam(parentId, key = '', val = '') {
        $("#".concat(parentId)).append("<div class='single_param'>\n\
            <label>key:value</label>\n\
            <input type='text' class='' name='key' value='" + key + "'> :\n\
            <input type='text' class='' name='val' value='" + val + "'>\n\
            <a href='javascript:void(0)' class='removeParam'>remove</a></div>");
    }

    function authenticate() {
        $.get('authenticate', {}).done(function (data) {
            if (!data.Status) {
                alert(data.Body);
            }
        });
    }

    function send() {
        $(".result").html("");
        $("#loadingText").removeAttr("hidden");
        $("#errorDisplayDiv").html("");
        var method = $("[name='method']").val();
        var url = setUrlParams();
        var params = setReqParams();

        sendAjaxRequest(url, params, method, handleAjaxError, setResult)
    }

    function sendAjaxRequest(url, data, type, errorCallBack, succCallBack) {
        $.ajax({
            url: url,
            data: data,
            type: type,
            error: errorCallBack,
            success: succCallBack
        });
    }

    function setUrlParams() {
        var url = $("[name='uri']").val();
        $.each(fetchParams('#url_parameters', 'key', 'val'), function (k, v) {
            if (k !== '') {
                url = url.replace('{' + k + '}', v);
            } else if (v !== '') {
                url += '/' + v;
            }
        });
        return url.replace(/[\/]+/g, "/");
    }

    function setReqParams() {
        return fetchParams('#json_parameters', 'key', 'val');
    }

    function fetchParams(parentId, keyName, valName) {
        var returnArr = {};
        if ($(parentId).children().length > 0) {
            var keys = $(parentId + ' input[name="' + keyName + '"]').map(function () {
                return $(this).val();
            }).get();
            var vals = $(parentId + ' input[name="' + valName + '"]').map(function () {
                return $(this).val();
            }).get();
            for (i = 0; i < keys.length; i++) {
                returnArr[keys[i]] = vals[i];
            }
        }
        return returnArr;
    }

    function setResult(data) {
        $(".result").removeAttr("hidden");
        $("#loadingText").attr("hidden", "true");
        $(".result").html(JSON.stringify(data, null, 2));
    }

    function handleAjaxError(XMLHttpRequest, textStatus, errorThrown) {
        $("#loadingText").attr("hidden", "true");
        $("#errorDisplayDiv").html(XMLHttpRequest.responseText);
        alert('status:' + XMLHttpRequest.status + ', status text: ' + XMLHttpRequest.statusText);

    }

    function extendInput(input) {
        $(input).attr('size', $(input).val().trim().length);
    }
    
    function fillForm(parentName, funcName) {               
        $("input[name='uri']").val(data[parentName][funcName].uri);
        $("select[name='method']").val(data[parentName][funcName].method);
        $.each(data[parentName][funcName].uri_params, function(key, value) {
            
            addParam('url_parameters', key, value);
	});
        $.each(data[parentName][funcName].req_params, function(key, value) {
            
            addParam('json_parameters', key, value);
	}); 
        window.scrollTo(0, 0);
    }
    
    function showUrls() {          
        var x = $("#module_select"); 
        var first=true;
        $.each(data, function(k, v) {
            if(first){
                insertSubModules(k);
                first = false;
            }                        
            x.append(
                $('<option></option>').val(k).html(k)
            );                      
        });
        x.on('change', function() {
            insertSubModules(this.value);
        });       
    }
    
    function insertSubModules(parent) {
        var html = '';                
        $.each(data[parent], function(k1, v1) {
            html += '<a href="javascript::void(0)" class="route" \n\
                parent="'+parent+'" value="'+k1+'">'+k1+'</a><br/>';
        });  
        $('#sub_routes').html(html);
    }
    
    function reset() {
        $('input[name="uri"]').val('');
        $('.result').html('');
        $('.result').attr('hidden', 'true');
        $('#url_parameters').html('');
        $('#json_parameters').html('');        
        $('#upload').replaceWith($('#upload').val('').clone(true));
        document.getElementById('upload').addEventListener('change', handleFileSelect, false);
    }
    
    data = {
        authentication: {
            login: {
                uri: "/login",     
                method: "get",                
            },
            logout: {
                uri: "/logout",     
                method: "get",                
            },            
            authenticate: {
                uri: "/authenticate",     
                method: "get",                
            },
            
        },        
        semesters: {
            semesters: {
                uri: "/semesters",     
                method: "get",                
            },
            courses_by_current_semester: {
                uri: "/current_semester",
                method: "get",
            },
            courses_by_semester: {
                uri: "/course/semester/{sem}",
                method: "get",
                uri_params :
                {
                    sem: "ws15",                    
                }            
            }
        },
        
        courses: {
            all_courses: {
              uri: "/courses",
              method: "get",               
            },            
            course_info: {
                uri: "/course/{cid}/course_info",
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }  
            }            
        },
        
        users: {
            view_user_role: {
                uri: "/view_user_role",
                method: "get"
            }
        },
        
        announcements: {
            all_announcement: {
                uri: "/course/{cid}/all_announcements",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            all_announcement_count: {
                uri: "/course/{cid}/all_announcements_count",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            single_announcement: {
                uri: "/course/{cid}/announcement/{itemId}",
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                    itemId: 0,
                } 
            },
            add_announcement: {
                uri: "/course/{cid}/add_announcement",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                    
                },    
                req_params :
                {
                    title: "announcement title",
                    body: "announcement body",
                }

            },
            update_announcement: {
                uri: "/course/{cid}/update_announcement/{itemId}",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",  
                    itemId: 0,
                },    
                req_params :
                {
                    title: "announcement title update",
                    body: "announcement body update",
                }

            },
            delete_announcement: {
                uri: "/course/{cid}/delete_announcement/{itemId}",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",   
                    itemId: 0,
                }            

            },
            upload_in_announcement: {
                uri: "/course/{cid}/upload_in_announcement",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },
                req_params :
                {
                    attachmentDirectory: "/ss16/16ss-55492/Lists/AnnouncementDocuments",
                }            

            },
        },        
        assignments: {
            all_assignments: {
                uri: "/course/{cid}/all_assignments",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            single_assignment: {
                uri: "/course/{cid}/assignment/{itemId}",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                    itemId: 0
                }            
            },
            add_assignment: {
                uri: "/course/{cid}/add_assignment",
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                        
                },
                req_params :
                {                    
                    description: "This is a sample assignment.",
                    title: "assignment title",                    
                }
            },
            delete_assignment: {
                uri: "/course/{cid}/delete_assignment/{itemId}",
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",  
                    itemId: 0,
                },                
            },
            provide_assignment_solution: {
                uri: "/course/{cid}/provide_assignment_solution/{assignmentId}/{gwsNameAlias}",
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492", 
                    assignmentId: 0,
                    gwsNameAlias: "gwsNameAlias",
                },
                req_params :
                {                    
                    comment: "Comment",                    
                }
            },
            upload_in_assignment: {
                uri: "/course/{cid}/upload_in_assignment",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },
                req_params :
                {
                    solutionDirectory: "[itemId]/ss16/16ss-55492/assessment/Lists/LA_SolutionDocuments/A[itemId]/S[solutionName]",
                }            

            },
            delete_assignment_solution: {
                uri: "/course/{cid}/delete_assignment_solution/{itemId}",
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",  
                    itemId: 0,
                },                
            },
        },
        emails: {
            all_emails: {
                uri: "/course/{cid}/all_emails",
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                                      
                },
            },
            single_email: {
                uri: "/course/{cid}/email/{itemId}",
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                                      
                   itemId: 0,
                },
                
            },
            add_email: {
                uri: "/course/{cid}/add_email",     
                method: "post",
                uri_params :
                {
                   cid: "16ss-55492",                                      
                },
                req_params :
                {
                    subject: "This is a sample email.",
                    recipients: "managers;tutors;students;",
                    cc: "administrator@example.rwth-aachen.de",
                }
            },
            delete_email: {
                uri: "/course/{cid}/delete_email/{itemId}",     
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                                      
                   itemId: 0,
                },
            },
            upload_in_email: {
                uri: "/course/{cid}/upload_in_email",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },                
            },            
        },        
        learning_materials: {
            all_learning_materials: {
                uri: "/course/{cid}/all_learning_materials",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                                
                }, 
            },
            all_learning_materials_count: {
                uri: "/course/{cid}/learning_material_count",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                                
                }, 
            },
            single_learning_material: {
                uri: "/course/{cid}/learning_material/{itemId}",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                                
                    itemId: 0,
                }, 
            },
            delete_learning_material: {
                uri: "/course/{cid}/delete_learning_material/{itemId}",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                                
                    itemId: 0,
                }, 
            },
            upload_in_learning_material: {
                uri: "/course/{cid}/upload_in_learning_material",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },      
                req_params :
                {
                    sourceDirectory: "/ss16/16ss-55492/Lists/StructuredMaterials",
                }
            },            
        },
        calendar: {
            all_course_events: {
                uri: "/all_course_events",     
                method: "get",
            },
            add_course_event: {
                uri: "/course/{cid}/add_course_event",     
                method: "post",
                uri_params: {
                    cid: "16ss-55492",
                },
                req_params: {
                    endDate: 123456789,
                    eventDate: 123456789,
                    title: "event title",
                }
            },
            delete_course_events: {
                uri: "/course/{cid}/delete_course_event/{itemId}",     
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                },
            },
            update_course_event: {
                uri: "/course/{cid}/update_course_event/{itemId}",     
                method: "post",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                },
                req_params: {
                    endDate: 123456789,
                    eventDate: 123456789,
                    title: "event title update",
                }
            },
            
        },
        whats_new: {
            whats_new: {
                uri: "/course/{cid}/whats_new",   
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            
            },
            whats_new_since: {
                uri: "/course/{cid}/whats_new_since/{pastMinutes}",
                method: "get",
                uri_params :                
                {
                    cid: "16ss-55492",                    
                    pastMinutes: "1440"
                }                            
            },
            whats_all_new_since: {
                uri: "whats_all_new_since/{pastMinutes}",            
                method: "get",
                uri_params :                
                {                                   
                    pastMinutes: "1440"
                }                            
            },
            whats_all_new_since_new: {
                uri: "whats_all_new_since_new/{pastMinutes}",            
                method: "get",
                uri_params :                
                {                                   
                    pastMinutes: "1440"
                }                            
            },
            whats_all_new_since_for_semester: {
                uri: "whats_all_new_since_for_semester/{sem}/{pastMinutes}",            
                method: "get",
                uri_params :                
                {                                   
                    pastMinutes: "1440",
                    sem: "ss16"
                }                            
            },
        },
        hyperlinks: {
            all_hyperlinks: {
                uri: "/course/{cid}/all_hyperlinks",   
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }
            },
            all_hyperlinks_count: {
                uri: "/course/{cid}/all_hyperlink_count",   
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }
            },
            single_hyperlink: {
                uri: "/course/{cid}/hyperlink/{itemId}",   
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",       
                    itemId: 0,
                }
            },
            add_hyperlink: {
                uri: "/course/{cid}/add_hyperlink",   
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                           
                },
                req_params: {
                    url: "http://www.example.com",
                    notes: "example url",
                    description: "example url"
                }
            },
            delete_hyperlink: {
                uri: "/course/{cid}/delete_hyper_link/{itemId}",   
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",       
                    itemId: 0,
                }
            },
            update_hyperlink: {
                uri: "/course/{cid}/update_hyperlink/{itemId}",   
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                      
                    itemId: 0,
                },
                req_params: {
                    url: "http://www.example1.com",
                    notes: "example url update",
                    description: "example url update"
                }
            }            
            
        },
        media_libraries: {
            all_media_libraries: {
                uri: "/course/{cid}/all_media_libraries",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                }
            },
            all_media_library_count: {
                uri: "/course/{cid}/all_media_library_count",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                }
            },
            single_media_library: {
                uri: "/course/{cid}/media_library/{itemId}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                }
            },
            delete_media_library: {
                uri: "/course/{cid}/delete_media_library/{itemId}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                }
            },
            upload_in_media_library: {
                uri: "/course/{cid}/upload_in_media_library",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },      
                req_params :
                {
                    sourceDirectory: "/ss16/16ss-55492/Lists/MediaLibrary",
                }
            }, 
            
        },
        discussions: {
            all_discussion_items: {
                uri: "/course/{cid}/all_discussion_items",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            all_discussion_item_count: {
                 uri: "/course/{cid}/all_discussion_item_count",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            all_discussion_root_items: {
                uri: "/course/{cid}/all_discussion_root_items",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                }            

            },
            single_discussion: {
                uri: "/course/{cid}/discussion_item/{itemId}",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
                    itemId: 0,
                }            
            },
            add_discussion_thread: {
                uri: "/course/{cid}/add_discussion_thread",     
                method: "post",
                uri_params :
                {
                   cid: "16ss-55492",                    
                },
                req_params :
                {
                    subject: "This is a sample discussion thread.",
                    body: "This is the content body <p>of the thread.</p>",
                }

            },   
            delete_discussion_item: {
                uri: "/course/{cid}/delete_discussion_item/{selfId}",     
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                    
                   selfId: 0,                    
                },                
            }, 
            add_discussion_thread_reply: {
                uri: "/course/{cid}/add_discussion_thread_reply/{replyToId}",     
                method: "post",
                uri_params :
                {
                   cid: "16ss-55492",                    
                   replyToId: 0,                    
                },
                req_params :
                {
                    subject: "This is a sample discussion thread reply.",
                    body: "This is the content body <p>of the thread reply.</p>",
                }

            },
            update_discussion_thread: {
                uri: "/course/{cid}/update_discussion_thread/{selfId}",     
                method: "post",
                uri_params :
                {
                   cid: "16ss-55492",                    
                   selfId: 0,                    
                },
                req_params :
                {
                    subject: "This is a sample discussion thread update.",
                    body: "This is the content body <p>of the thread update.</p>",
                }

            },   
            update_discussion_thread_reply: {
                uri: "/course/{cid}/update_discussion_thread_reply/{selfId}",     
                method: "post",
                uri_params :
                {
                   cid: "16ss-55492",                    
                   selfId: 0,                    
                },
                req_params :
                {
                    subject: "This is a sample discussion thread reply update.",
                    body: "This is the content body <p>of the thread reply update.</p>",
                }

           },
        },      
        literatures: {
            all_literatures: {
                uri: "/course/{cid}/all_literatures",     
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                                       
                },
            },                   
            single_literatures: {
                uri: "/course/{cid}/literature/{itemId}",     
                method: "get",
                uri_params :
                {
                   cid: "16ss-55492",                 
                   itemId: 0,
                },
            },     
            add_literature: {
                uri: "/course/{cid}/add_literature",
                method: "post",
                uri_params: 
                {
                    cid: "16ss-55492",            
                },
                req_params: 
                {
                    title: "History of RWTH Aachen University",
                    authors: "Dr. Gustav Geier",
                    year: "2015",                    
                    contentType: "Book",
                    publisher: "Publisher",
                }
            },
            update_literature: {
                uri: "/course/{cid}/update_literature/{itemId}",
                method: "post",
                uri_params: 
                {
                    cid: "16ss-55492",   
                    itemId: 0,
                },
                req_params: 
                {
                    title: "Update literature",
                    authors: "Update",
                    year: "2015",                    
                    contentType: "Book",
                    publisher: "Publisher",
                }
            },
            delete_literature: {
                uri: "/course/{cid}/delete_literature/{itemId}",
                method: "get",
                uri_params: 
                {
                    cid: "16ss-55492",            
                    itemId: 0
                },                
            }
        }, 
        shared_documents: {
            all_shared_documents: {
                uri: "/course/{cid}/all_shared_documents",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                }
            },   
            all_shared_documents_count: {
                uri: "/course/{cid}/all_shared_documents_count",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                }
            },
            delete_shared_document: {
                uri: "/course/{cid}/delete_shared_document/{itemId}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                }
            },
            upload_in_shared_document: {
                uri: "/course/{cid}/upload_in_shared_document",     
                method: "post",
                uri_params :
                {
                    cid: "16ss-55492",                                
                },      
                req_params :
                {
                    sourceDirectory: "/ss16/16ss-55492/collaboration/Lists/SharedDocuments",
                }
            },
        },
        wikis: {
            all_wikis: {
                uri: "/course/{cid}/all_wikis",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",                    
                }
            },
            all_wiki_count: {
                uri: "/course/{cid}/all_wiki_count",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",                    
                }
            },
            view_wiki: {
                uri: "/course/{cid}/wiki/{itemId}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                }
            },
            view_wiki_version: {
                uri: "/course/{cid}/wiki_version/{itemId}/{versionId}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                    itemId: 0,
                    versionId: 0,
                }
            },
            add_wiki: {
                uri: "/course/{cid}/add_wiki",
                method: "post",
                uri_params: 
                {
                    cid: "16ss-55492",            
                },
                req_params: 
                {
                    title: "This is a wiki title",                   
                    body: "This is a wiki body",                   
                }
            },
            update_wiki: {
                uri: "/course/{cid}/update_wiki/{itemId}",
                method: "post",
                uri_params: 
                {
                    cid: "16ss-55492",            
                    itemId: 0,
                },
                req_params: 
                {
                    title: "This is a wiki title update",                   
                    body: "This is a wiki body update",                   
                }
            },
            delete_wiki: {
                uri: "/course/{cid}/delete_wiki/{itemId}",
                method: "get",
                uri_params: 
                {
                    cid: "16ss-55492",            
                    itemId: 0,
                },                
            }
            
        },
        others: {
            view_user_role: {
                uri: "/course/{cid}/view_user_role",
                method: "get",
                uri_params: 
                {
                    cid: "16ss-55492",                                
                },
            },
            create_folder: {
                uri: "/course/{cid}/createFolder",
                method: "post",
                uri_params: {
                    cid: "16ss-55492",                    
                },                
                req_params: {
                    moduleNumber: 1,
                    desiredFolderName: "New folder",                   
                    sourceDirectory: "",
                }
            },
            view_active_features: {
                uri: "/course/{cid}/active_features",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                },
            },
            view_all_count: {
                uri: "/course/{cid}/all_count",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",
                },
            },
            download_file: {
                uri: "/course/{cid}/download_file/{fileName}/{downloadUrl}",
                method: "get",
                uri_params: {
                    cid: "16ss-55492",                    
                },
                req_params: {
                    fileName: "Lab Kick Off.pptx",
                    downloadUrl: "|/ss16/16ss-55492/Lists/StructuredMaterials/Hello/Lab%20Kick%20Off.pptx",
                }
            },
            inbox: {
                uri: "inbox/{moduleName}/{pastMinutes}",     
                method: "get",
                uri_params :
                {
                    moduleName: "announcements",
                    pastMinutes: 5,                                
                },                
            },
        }
    }
</script>
