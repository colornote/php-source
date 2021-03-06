var app = getApp();

Page({
    data: {
        page: 1,
        pagesize: 20,
        loadend: !1
    },
    onLoad: function(a) {
        var e = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadGoodList",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0
                });
            }
        });
    },
    onReady: function() {
        var a = {};
        a.change_list_bg = app.module_url + "resource/wxapp/sport/change-list-bg.png", this.setData({
            images: a
        }), app.look.sport_footer(this);
    },
    onShow: function() {
        this.setData({
            coin: app.globalData.userInfo.coin
        });
    },
    onHide: function() {},
    onUnload: function() {},
    onPullDownRefresh: function() {
        var e = this;
        app.util.request({
            url: "entry/wxapp/sport",
            showLoading: !1,
            method: "POST",
            data: {
                op: "loadGoodList",
                page: 1,
                pagesize: e.data.pagesize
            },
            success: function(a) {
                wx.stopPullDownRefresh();
                var t = a.data;
                t.data.list && e.setData({
                    list: t.data.list,
                    page: 1,
                    loadend: !1
                });
            },
            fail: function(a) {
                app.look.alert(a.data.message), e.setData({
                    loadend: !0,
                    list: []
                });
            }
        });
    },
    onReachBottom: function() {
        if (!this.data.loadend) {
            var e = this;
            app.util.request({
                url: "entry/wxapp/sport",
                showLoading: !1,
                method: "POST",
                data: {
                    op: "loadGoodList",
                    page: e.data.page + 1,
                    pagesize: e.data.pagesize
                },
                success: function(a) {
                    var t = a.data;
                    t.data.list && e.setData({
                        list: e.data.list.concat(t.data.list),
                        page: e.data.page + 1
                    });
                },
                fail: function(a) {
                    app.look.alert(a.data.message), e.setData({
                        loadend: !0
                    });
                }
            });
        }
    }
});