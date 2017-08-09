//source from: http://igstan.ro/posts/2009-01-11-ajax-file-upload-with-pure-javascript.html
//But with changes to 'sendasbinary' and other binary conv. calls which do not
//work in chrome. These calls were rpelaced with fileReader.
//Also note that the source uses the same SendAsBinary attempt in html.
//For the image preview. Replace image preview code on html side with:
// var reader = new FileReader();
//	 console.log(input.files[0]);
//	 //Filereader is asynchronous
//	 reader.onload = function(event) {
//  img.src = event.target.result;
//	};
//	 reader.readAsDataURL(input.files[0]);
//    }, false);

/**
 * @param DOMNode form
 */

var Uploader = function(form) {
    this.form = form;
	this.response = "";	
};

Uploader.prototype = {
	
    /**
     * @param Object HTTP headers to send to the server, the key is the
     * header name, the value is the header value
     */
    headers : {},

   /**
 * @return Array
 */
get elements() {
    var fields = [];

    // gather INPUT elements
    var inputs = this.form.getElementsByTagName("INPUT");
    for (var l=inputs.length, i=0; i<l; i++){
        fields.push(inputs[i]);
    }

  //  // gather SELECT elements
  //  var selects = this.form.getElementsByTagName("SELECT");
  //  for (var l=selects.length, i=0; i<l; i++){
  //      fields.push(selects[i]);
  //  }

    return fields;
},

   /**
 * @return String
 */
generateBoundary: function() {
    return "AJAX-----------------------" + (new Date).getTime();
},

   /**
 * @param Array elements
 * @param String boundary
 * @return String
 */
buildMessage : function(elements, boundary) {
    var CRLF = "\r\n";
    var parts = [];

    elements.forEach(function(element, index, all) {
        var part = "";
        var type = "TEXT";

        if (element.nodeName.toUpperCase() === "INPUT") {
            type = element.getAttribute("type").toUpperCase();
        }

        if (type === "FILE" && element.files.length > 0) {
            var fieldName = element.name;
            var fileName = element.files[0].name;
            /*
             * Content-Disposition header contains name of the field
             * used to upload the file and also the name of the file as
             * it was on the user's computer.
             */
            part += 'Content-Disposition: form-data; ';
            part += 'name="' + fieldName + '"; ';
            part += 'filename="'+ fileName + '"' + CRLF;

            /*
             * Content-Type header contains the mime-type of the file
             * to send. Although we could build a map of mime-types
             * that match certain file extensions, we'll take the easy
             * approach and send a general binary header:
             * application/octet-stream
             */
            part += "Content-Type: application/octet-stream";
            part += CRLF + CRLF; // marks end of the headers part

            /*
             * File contents read as binary data, obviously
             */
			 //file reader is asynchronous
			 var reader = new FileReader();
			 reader.onload = function(event) {
				part += event.target.result + CRLF;
				//alert(event.target.result);
			};
            //part += 
			reader.readAsBinaryString(element.files[0]);
       } else {
            /*
             * In case of non-files fields, Content-Disposition
             * contains only the name of the field holding the data.
             */
            part += 'Content-Disposition: form-data; ';
            part += 'name="' + element.name + '"' + CRLF + CRLF;

            /*
             * Field value
             */
            part += element.value + CRLF;
       }

       parts.push(part);
    });

    var request = "--" + boundary + CRLF;
        request+= parts.join("--" + boundary + CRLF);
        request+= "--" + boundary + "--" + CRLF;

    return request;
},

    /**
 * @return null
 */
send : function() {
	
    var boundary = this.generateBoundary();
    var xhr = new XMLHttpRequest;
	var parent = this;
    xhr.open("POST", this.form.action, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          //  alert(xhr.responseText);
		   //new; by Allison Klinesmith
			response = xhr.responseText;
			//if we referenced $(this), it would think we were referencing xhr. So we're calling from the context of parent.
			$(parent).trigger('uploadResponse', response);
        }
    };
    var contentType = "multipart/form-data; boundary=" + boundary;
    xhr.setRequestHeader("Content-Type", contentType);

    for (var header in this.headers) {
        xhr.setRequestHeader(header, headers[header]);
    }

    // here's our data variable that we talked about earlier
    var data = this.buildMessage(this.elements, boundary);
	var reader = new FileReader();
	 
    
    // finally send the request as binary data
    xhr.send(data);
},


 on : function(event, cb) {
         $(this).on(event, cb);
    },

};