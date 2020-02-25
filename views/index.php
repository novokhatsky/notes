<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Справочник</title>
    <link href="/notes/css/main.css" rel="stylesheet" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php require_once 'views/tmpl/auth.php'; ?>

<div id="app" class="content algn-cnt">
    <div class="err"><?=$msg->popValue()?></div>
    <a href="/notes/edit"><button class="button">создать</button></a><br />
    Поиск по ключевым словам:<br />
    <input type="text" v-model="seek_str" v-on:click="clear_seek" class="input"><br />
    Результат поиска:<br />
    <div v-for="item in list_items">
        <div><a v-bind:href="'/notes/get/' + item.id_article">{{item.header}}</a></div>
    </div>
</div>

<script src="/js/vue.min.js"></script>
<script src="/js/vue-resource.min.js"></script>

<script>

    Vue.use(VueResource);
    var app = new Vue({
        el: '#app',
        data: {
            server: '<?php echo "http://", $_SERVER["HTTP_HOST"]; ?>/notes/',
            seek_str: '',
            list_items: [],
        },
        watch: {
            seek_str: function() {
                this.msg = '';
                if (this.seek_str.length > 1) {
                    this.start_seek();
                }
            },
        },
        methods: {
            clear_seek: function() {
                this.seek_str = '';
                this.list_items = [];
            },
            start_seek: function() {
                this.$http.get(this.server + "seek/" + this.seek_str).then(
                    function(otvet) {
                        this.list_items = otvet.data;
                    },
                    function(errr) {
                        console.log( errr );
                    }
                );
            },
        }
    })
</script>

</body>
</html>
