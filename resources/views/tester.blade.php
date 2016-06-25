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
                    <input type="text" class="" name="uri" size="30" value="/course/{cid}" onchange="extendInput(this)">            
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
                    <textarea class="result" hidden="true" cols="50" rows="20"></textarea>
                </div>        
                <div id="errorDisplayDiv">            
                </div>
            </div>
            <div style="width: 45%; display: inline-block; vertical-align:top;">                
                <p>Routes:</p>
                <h4>Announcements:</h4>
                <a href="javascript::void(0)" onclick="fillForm('all_announcement')">view all announcements</a>
                <h4>What is new:</h4>
                <a href="javascript::void(0)" onclick="fillForm('whats_new')">what is new</a><br/>
                <a href="javascript::void(0)" onclick="fillForm('whats_new_since')">what is new since</a><br/>
                <a href="javascript::void(0)" onclick="fillForm('whats_all_new_since')">what is all new since</a><br/>
                <a href="javascript::void(0)" onclick="fillForm('whats_all_new_since_for_semester')">what is all new since for semester</a><br/>
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
        document.getElementById('upload').addEventListener('change', handleFileSelect, false);
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
    
    function fillForm(funcName) {
        $(".result").html('');
        $(".result").attr("hidden", "true");
        $("input[name='uri']").val(data[funcName].uri);
        $.each(data[funcName].uri_params, function(key, value) {
            
            addParam('url_parameters', key, value);
	});
    }
    
    data = {
        all_announcement: {
            uri: "/course/{cid}/all_announcements",            
            uri_params :
            {
                cid: "16ss-55492",                    
            }            
            
        },
        whats_new: {
            uri: "/course/{cid}/whats_new",            
            uri_params :
            {
                cid: "16ss-55492",                    
            }            
        },
        whats_new_since: {
            uri: "/course/{cid}/whats_new_since/{pastMinutes}",            
            uri_params :                
            {
                cid: "16ss-55492",                    
                pastMinutes: "1440"
            }                            
        },
        whats_all_new_since: {
            uri: "whats_all_new_since/{pastMinutes}",            
            uri_params :                
            {                                   
                pastMinutes: "1440"
            }                            
        },
        whats_all_new_since_for_semester: {
            uri: "whats_all_new_since_for_semester/{sem}/{pastMinutes}",            
            uri_params :                
            {                                   
                pastMinutes: "1440",
                sem: "ss16"
            }                            
        },
    }
</script>
