<?php
use yii\helpers\Url;
/** @var string $state */
/** @var string $scope */
/** @var string $response_type */
/** @var string $approval_prompt */
/** @var string $client_id */
/** @var string $redirect_uri */
?>
<div id="app">
    <div v-if="showLogin">
        <form>
            <input v-model="username" type="text" name="username" placeholder="username" >
            <br/>
            <input v-model="password" type="password" name="password" placeholder="password">
            <br/>
            <button type="button" v-on:click="login">
                Sign in
            </button>
        </form>
    </div>
    <div v-else>
        <span>App Name:{{ appName }}</span><br/>
        <span>Scopes:</span>
        <span v-for="scope in scopes">{{ scope }}</span>
        <br/>
        <button type="button" v-on:click="confirm">
            confirm
        </button>
    </div>
</div>
<script type="text/javascript">
    var data = {
        csrf:'<?php echo Yii::$app->request->getCsrfToken(); ?>',
        state:'<?php echo $state;?>',
        scope:'<?php echo $scope;?>',
        response_type:'<?php echo $response_type;?>',
        approval_prompt:'<?php echo $approval_prompt;?>',
        client_id:'<?php echo $client_id;?>',
        redirect_uri:'<?php echo $redirect_uri;?>'
    };
    var app = new Vue({
        el: '#app',
        data: {
            username: 'test',
            password: '111111',
            showLogin: true,
            appName: '',
            scopes: []
        },
        methods: {
            login: function () {
                var _this = this;
                axios.post('<?php echo Url::to(['login'], true); ?>', {
                    username: _this.username,
                    password: _this.password,
                    _csrf: data.csrf,
                    state: data.state,
                    scope: data.scope,
                    response_type: data.response_type,
                    approval_prompt: data.approval_prompt,
                    client_id: data.client_id,
                    redirect_uri: data.redirect_uri
                })
                .then(function (response) {
                    if (response.data.status) {
                        _this.showLogin = false;
                        _this.appName = response.data.data.client_name;
                        _this.scopes = response.data.data.scopes;
                    } else {
                        alert('system error.');
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            confirm: function () {
                axios.post('<?php echo Url::to(['confirm'], true); ?>', {
                        _csrf: data.csrf,
                        state: data.state,
                        scope: data.scope,
                        response_type: data.response_type,
                        approval_prompt: data.approval_prompt,
                        client_id: data.client_id,
                        redirect_uri: data.redirect_uri
                    })
                    .then(function (response) {
                        console.log(response.data);
                        if (response.data.status) {
                            window.location.href = response.data.data.redirect;
                        } else {
                            alert('system error.');
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }
    });
</script>