/**
 * Created by Orel on 7/2/2017.
 */
var unitTests;
unitTests = {
    init: function () {
        this.console = $("#console");
        this.postId = 301;

        unitTests.autoTest();

    },

    autoTest: function () {
        var self = unitTests, res = "";
        self.printToConsole("<----UNIT TESTS AUTO TEST ---->");



        /* sign up tests  TODO: return user not id*/
        self.printToConsole("");
        self.printToConsole("USER SIGN UP:");

        self.printToConsole('signUp("    ","123","te");');
        self.signUp("    ", "123", "te");
        self.printToConsole(unitTests.res);

        self.printToConsole('signUp("usedEmail@gmail.com", "123456", "tester");');
        self.signUp("usedEmail@gmail.com", 123456, "tester");
        self.printToConsole(unitTests.res);

        self.printToConsole('signUp("tester@gmail.com", "123456", "tester");');
        self.signUp("test@gmail.com", 123456, "tester");
        self.printToConsole(unitTests.res);



        /* sign up tests */
        self.printToConsole("");
        self.printToConsole("USER LOGIN:");

        self.printToConsole('login("tester@gmail.com", "wrongPwd");');
        self.login("tester@gmail.com", "wrongPwd");
        self.printToConsole(unitTests.res);

        self.printToConsole('login("oreloffir@gmail.com", "123456");');
        self.login("oreloffir@gmail.com", "123456");
        self.printToConsole(unitTests.res);


        /* add post */
        self.printToConsole("");
        self.printToConsole("ADD POST:");

        self.printToConsole('addPost("Auto test post", "XSS","1000", "http://autotest.com", 2, "");');
        self.addPost("Auto test post", "<script>alert('XSS')</script>", "1000", "http://autotest.com", 2, '');
        self.printToConsole(unitTests.res);
        console.log(unitTests.res);
        self.postId = unitTests.res.id;

        self.printToConsole('addPost("test", "test", "100", "http:notValidUrl", 5, "");');
        self.addPost("test", "test", "100", "http:notValidUrl", 5, "");
        self.printToConsole(unitTests.res);


        /* edit post */
        self.printToConsole("");
        self.printToConsole("EDIT POST:");

        self.printToConsole('editPost('+self.postId+', "Auto test post", "Auto test post description", "1000", "http://autotest.com", 2, "", " ");');
        self.editPost(self.postId,"Auto test post", "Auto test post description", "1000", "http://autotest.com", 2,"" ," ");
        self.printToConsole(unitTests.res);

        self.printToConsole('editPost('+self.postId+', "Auto test edit post", "Auto test edit post description", "500", "http://autotest.com", 3, "3x3x", " ");');
        self.editPost(self.postId,"Auto test edit post", "Auto test edit post description", "500", "http://autotest.com", 3, '3x3x', ' ');
        self.printToConsole(unitTests.res);


        /* add comment */
        self.printToConsole("");
        self.printToConsole("ADD COMMENT:");

        self.printToConsole('addComment('+self.postId+', "XSS");');
        self.addComment(self.postId,"<script>alert('XSS')</script>");
        self.printToConsole(unitTests.res);



    },

    signUp: function (email, password, displayName) {
        console.log("sign up");
        var dataString = "email=" + email + "&pwd=" + password + "&displayName=" + displayName;
        console.log(dataString);
        return $.ajax({
            url: "../ajax/signUpAjax.php",
            type: "POST",
            dataType: "JSON",
            data: dataString,
            async: false,
            success: function (callback) {
                unitTests.res = callback;
            }
        });
    },

    login: function (email, password) {
        console.log("login");
        var dataString = "email=" + email + "&password=" + password;
        console.log(dataString);
        return $.ajax({
            url: "../ajax/loginAjax.php",
            type: "POST",
            dataType: "JSON",
            data: dataString,
            async: false,
            success: function (callback) {
                unitTests.res = callback;
            }
        });
    },

    addPost: function (title, description, price, URL, category, couponCode) {
        console.log("addPost");
        var dataString = "title="+title+"&description="+description+"&price="+price+"&URL="+URL+"&category="+category+"&couponCode="+couponCode;
        console.log(dataString);
        return $.ajax({
            url: "../ajax/addPostAjax.php",
            type: "POST",
            dataType: "JSON",
            data: dataString,
            async: false,
            success: function (callback) {
                unitTests.res = callback;
            }
        });
    },

    editPost: function (postId, title, description, price, URL, category, couponCode) {
        console.log("editPost");
        var dataString = "postId="+postId+"&title="+title+"&description="+description+"&price="+price+"&URL="+URL+"&category="+category+"&couponCode="+couponCode+"&imagePath=demo";
        console.log(dataString);
        return $.ajax({
            url: "../ajax/addPostAjax.php",
            type: "POST",
            dataType: "JSON",
            data: dataString,
            async: false,
            success: function (callback) {
                unitTests.res = callback;
            }
        });
    },

    addComment: function (postId, commentBody) {
        var dataString  = "postid="+postId+"&commentbody="+commentBody;
        console.log(dataString);
        return $.ajax({
            url: "../ajax/addCommentAjax.php",
            type: "POST",
            dataType: "JSON",
            data: dataString,
            async: false,
            success: function (callback) {
                unitTests.res = callback;
            }
        });
    },

    printToConsole: function (print) {
        if(print instanceof Object) {
            $.each(print, function (k, v) {
                console.log(v === Array);
                if(v instanceof Object && !(v instanceof String))
                    unitTests.printToConsole(v);
                else
                    $(unitTests.console).append("<span style='color:mediumpurple;'>"+ k + "</span>: <span style='color:orangered;'>" + v + "</span><br/>");
            });
        }else{
            $(unitTests.console).append("<span style='color:#999999;'>"+print+"</span><br/>");
        }
    }
};