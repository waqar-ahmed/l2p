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
            <div style="width: 45%; display: inline-block;">
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
                <span id="loadingText" hidden="true">loading...</span>
                <div>
                    <textarea class="result" hidden="true" cols="70" rows="20"></textarea>
                </div>        
                <div id="errorDisplayDiv">            
                </div>
            </div>
            <div id="routes" style="width: 45%; display: inline-block; vertical-align:top;">                
                <p>Routes:</p>                
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
    }
    
    function showUrls() {
        var html = '';
        $.each(data, function(k, v) {
            html += '<h4>' + k + ': </h4>';
            $.each(v, function(k1, v1) {
                html += '<a href="javascript::void(0)" class="route" \n\
                    parent="'+k+'" value="'+k1+'">'+k1+'</a><br/>'
            });                        
        });
        $('#routes').html(html);
    }
    
    function reset() {
        $('.result').html('');
        $('.result').attr('hidden', 'true');
        $('#url_parameters').html('');
        $('#json_parameters').html('');        
        $('#upload').replaceWith($('#upload').val('').clone(true));
        document.getElementById('upload').addEventListener('change', handleFileSelect, false);
    }
    
    data = {
        announcements: {
            all_announcement: {
                uri: "/course/{cid}/all_announcements",     
                method: "get",
                uri_params :
                {
                    cid: "16ss-55492",                    
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
        emails: {
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
        },
        semesters: {
            semesters: {
                uri: "/semesters",     
                method: "get",                
            },
        }
    }
</script>
