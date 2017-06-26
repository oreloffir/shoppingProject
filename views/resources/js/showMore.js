/**
 * Created by Orel on 6/26/2017.
 */

var showMore = {
    init: function(){
        this.loadRequest                = false;
        this.loadMoreInfo               = $("#loadMoreInfo");
        this.postsDisplayContainer      = $("#postsDisplayContainer");
        this.loadRequest                = false;
        this.bindEvent();
    },
    bindEvent: function(){
        $(document).scroll(function(){
            var correctPosition = $(document).scrollTop();
            //console.log("correctPosition:"+correctPosition);
            //console.log("(document).height:"+$(document).height());
            if((correctPosition > $(document).height()-1000) && !showMore.loadRequest){
                showMore.loadRequest = true;
                showMore.ajaxMore();
            }
        });
    },
    ajaxMore: function(){
        dataString = "pageNumber="+showMore.loadMoreInfo.attr("pageNumber");
        if(showMore.category)
            dataString+= "category="+showMore.loadMoreInfo.attr("category");
        if(showMore.sortby)
            dataString+= "postsOrder="+showMore.loadMoreInfo.attr("postsOrder");
        console.log(dataString);
        $.ajax({
            url: "ajax/loadMoreAjax.php",
            type: "GET",
            data: dataString,
            dataType: "json",
            success: function(callback){
                if(callback!="0"){
                    console.log(" Ajax suc");
                    showMore.fetchResult(callback);
                }
            }
        });
    },
    fetchResult: function(posts){
        console.log("showMore fetch");
        var htmlPostsString = "";
        //create string to append
        //rows = self.arrayChunk(posts, 4);
        for(var i = 0 ; i < 12 ; i+=4){
            var limit = i+4;
                htmlPostsString+= "<div class=\"row\">";
                for(i; i<limit; i++) {
                    htmlPostsString += "<div class=\"col-xs-12 col-sm-6 col-md-3\">";
                    htmlPostsString += "<div class=\"post-mini\">";
                    htmlPostsString += "<div class=\"post-mini-top\">";
                    htmlPostsString += "<a href=\"profile.php?id=" + posts[i]['publisherId'] + "\">" + posts[i]['displayName'] + "</a><span>" + posts[i]['time'] + "</span>";
                    htmlPostsString += "</div>";
                    htmlPostsString += "<div class=\"post-mini-title\">";
                    htmlPostsString += "<a href=\"#\" class=\"postDialog\" postId=" + posts[i]['id'] + ">" + posts[i]['title'] + "</a>";
                    htmlPostsString += "</div>";
                    htmlPostsString += "<div class=\"post-mini-main\">";
                    htmlPostsString += "<div class=\"post-mini-img\">";
                    htmlPostsString += "<img src=\"./uploads/" + posts[i]['imagePath'] + "\" class=\"img-responsive postDialog\" postId=" + posts[i]['id'] + ">";
                    htmlPostsString += "</div>";
                    htmlPostsString += "<div class=\"post-mini-img-des\">";
                    htmlPostsString += "<span>" + posts[i]['description'].substr(0, 200) +"..</span>";
                    htmlPostsString += "</div>";
                    htmlPostsString += "</div>";
                    htmlPostsString += "</div>";
                    htmlPostsString += "</div>";
                }
                htmlPostsString+= "</div>";
        }
        showMore.postsDisplayContainer.append(htmlPostsString);
        showMore.loadMoreInfo.attr("pageNumber", parseInt(showMore.loadMoreInfo.attr("pageNumber"))+1);
        showMore.loadRequest = false;
        displayPost.init();
    },

    arrayChunk : function ( array , chunk) {
        temparray = new Array();
        for (i=0,j=array.length; i<j; i+=chunk) {
            temparray.add(array.slice(i,i+chunk));
        }
    }
};
