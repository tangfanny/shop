
function  del(url){
    if(url.substr(0,1)=="/"){
        return url.substring(1);
    }else {
        return url;
    }
}
