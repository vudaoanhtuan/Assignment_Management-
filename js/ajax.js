function load_ajax(id) {
    // Tạo một biến lưu trữ đối tượng XML HTTP. Đối tượng này
    // tùy thuộc vào trình duyệt browser ta sử dụng nên phải kiểm
    // tra như bước bên dưới
    var xmlhttp;
     
    // Nếu trình duyệt là  IE7+, Firefox, Chrome, Opera, Safari
    if (window.XMLHttpRequest)
    {
        xmlhttp = new XMLHttpRequest();
    }
    // Nếu trình duyệt là IE6, IE5
    else
    {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
     
    // Khởi tạo một hàm gửi ajax
    xmlhttp.onreadystatechange = function()
    {
        // Nếu đối tượng XML HTTP trả về với hai thông số bên dưới thì mọi chuyện 
        // coi như thành công
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            // Sau khi thành công tiến hành thay đổi nội dung của thẻ div, nội dung
            // ở đây chính là 
            document.getElementById("list_output").innerHTML = xmlhttp.responseText;
        }
    };
     
    // Khai báo với phương thức GET, và url chính là file result.php
    xmlhttp.open("GET", "ajax/getlog.php?id=" + id, true);
     
    // Cuối cùng là Gửi ajax, sau khi gọi hàm send thì function vừa tạo ở
    // trên (onreadystatechange) sẽ được chạy
    xmlhttp.send();
}	


function getListLog(submit_id) {
    var xmlhttp;
    $("#output").hide();

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("list_output").innerHTML = xmlhttp.responseText;
        }
    };
     
    xmlhttp.open("GET", "ajax/getListLog.php?submit_id=" + submit_id, true);

    xmlhttp.send();
}

function getLogOutput(submit_id, log_id) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("log_output").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "ajax/getLog.php?submit_id=" + submit_id + "&log_id=" + log_id + "&type=log", true);
    xmlhttp.send();
}

function getStdOutput(submit_id, log_id) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("std_output").innerHTML = xmlhttp.responseText;
        }
    };
    xmlhttp.open("GET", "ajax/getLog.php?submit_id=" + String(submit_id) + "&log_id=" + String(log_id) + "&type=std", true);
    xmlhttp.send();
}

function getLog(submit_id, log_id) {
    getLogOutput(submit_id, log_id);
    getStdOutput(submit_id, log_id);
    $("#output").show();
}

function getError(submit_id) {
    var xmlhttp;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    }
    else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }

    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("list_output").innerHTML = xmlhttp.responseText;
            $("#output").hide();
        }
    };
     
    xmlhttp.open("GET", "ajax/getError.php?submit_id=" + submit_id, true);

    xmlhttp.send();
}