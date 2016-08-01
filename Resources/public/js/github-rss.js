function GithubRssBlock(options) {
    this.settings = options.settings;
    this.init();
}

GithubRssBlock.prototype = {

    init: function() {
        if(jQuery('.'+this.settings.id).length > 0) {
            this.catchLinks(this);
        }
    },

    catchLinks: function(obj) {
        var base_url = obj.settings.base_url;

        $('.'+this.settings.id).find('a').each(function(e) {
            var href = $(this).attr('href');
            $(this).attr('href', base_url+href);
            $(this).attr("target", "_blank");
        });
    }
}
