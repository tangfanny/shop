/* 确认收货 */
function _confirm(order_sn) {
	if (confirm("确定该操作吗？")) {
        $.post("?m=user&c=order&a=confirm", {
        	order_sn:order_sn
        }, function(ret) {
        	if(ret.status == 1) {
        		location.reload();
        		return true;
        	} else {
        		alert(ret.info);
        		return false;
        	}
        }, 'JSON')
    }
}

/* 取消订单 */
function _cancel(order_sn) {
	if (confirm("确定取消该订单吗？")) {
        $.post("?m=user&c=order&a=cancel", {
        	order_sn:order_sn
        }, function(ret) {
        	if(ret.status == 1) {
        		location.reload();
        		return true;
        	} else {
        		alert(ret.info);
        		return false;
        	}
        }, 'JSON')
    }
}

