  <script type="text/javascript">
            var memberid=1;
            function loadXMLDoc(value)
            {
                alert("zhangdao");
                var dataP={value:value};
                $.get("http://192.168.8.79/celebritytop/index.php/ajax_serv?value="+value,dataP,function(){
                    
                });
                /*
                var xmlhttp;
                var memberid=value;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (!((xmlhttp.readyState==4) &&(xmlhttp.status==200)))
                    {
                        document.getElementById("maincontent").innerHTML="请稍等，正在加载中";
                    }
                    else{
                        document.getElementById("maincontent").innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","http://192.168.8.79/celebritytop/index.php/ajax_serv?value="+memberid,true);
                xmlhttp.send();
                 */
            }

	
            function loadXMLDoc()
            {
                /*
                var xmlhttp;
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (!(xmlhttp.readyState==4 && xmlhttp.status==200))
                    {
                        document.getElementById("maincontent").innerHTML="请稍等，正在加载中";
                    }
                    else{
                        document.getElementById("maincontent").innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","http://192.168.8.79/celebritytop/index.php/ajax_serv?value="+memberid,true);
                xmlhttp.send();*/
                $.get("http://192.168.8.79/celebritytop/index.php/ajax_serv?value="+value);
            }


        </script>/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


