function updateChar(id, length_limit){
		var comment=id;

		var length = calculate_msglen(comment.value);
		document.getElementById(id.name+"Limit").innerHTML = length;

		if (length > length_limit) {
				alert("�ִ� " + length_limit + "byte�̹Ƿ� �ʰ��� ���ڼ��� �ڵ����� �����˴ϴ�.");
				comment.value = comment.value.replace(/\r\n$/, "");
				comment.value = assert_msglen(comment.value, length_limit, id.name);
		}
}

function smsMsgCount(msg){
	$("#sms-count").html(calculate_msglen(msg));
}

function calculate_msglen(message){
		var nbytes = 0;

		for (i=0; i<message.length; i++) {
				var ch = message.charAt(i);
				if(escape(ch).length > 4) {
						nbytes += 2;
				} else if (ch == '\n') {
						if (message.charAt(i-1) != '\r') {
								nbytes += 1;
						}
				} else if (ch == '<' || ch == '>') {
						nbytes += 4;
				} else {
						nbytes += 1;
				}
		}

		return nbytes;
}

function assert_msglen(message, maximum)
{
		var inc = 0;
		var nbytes = 0;
		var msg = "";
		var msglen = message.length;

		for (i=0; i<msglen; i++) {
				var ch = message.charAt(i);
				if (escape(ch).length > 4) {
						inc = 2;
				} else if (ch == '\n') {
						if (message.charAt(i-1) != '\r') {
								inc = 1;
						}
				} else if (ch == '<' || ch == '>') {
						inc = 4;
				} else {
						inc = 1;
				}
				if ((nbytes + inc) > maximum) {
						break;
				}
				nbytes += inc;
				msg += ch;
		}
		document.getElementById("commentLimit").innerHTML = nbytes;
		return msg;
}