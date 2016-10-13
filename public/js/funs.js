/**
 * 公共js函数库
 */
/*
 * 建立一個可存取到該file的url（图片预览用）
 * @param file 文件域对象
 */
function getObjectURL(file) {
    var url = null ; 
    if (window.createObjectURL!=undefined) { // basic
        url = window.createObjectURL(file);
    } else if (window.URL!=undefined) { // mozilla(firefox)
        url = window.URL.createObjectURL(file);
    } else if (window.webkitURL!=undefined) { // webkit or chrome
        url = window.webkitURL.createObjectURL(file);
    }
    return url;
}