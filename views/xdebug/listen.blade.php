<!DOCTYPE html>
<html>
<head>
    @include('inc_header')
</head>
<body style="overflow: hidden">
<div id="app">
    <el-container>
        <el-header>
            <el-breadcrumb separator-class="el-icon-arrow-right">
                <el-breadcrumb-item><a style="cursor: pointer"
                                       @click="location.reload()">监听设置({{ $trace_conf['en'] ? '监听中，' . date('Y-m-d H:i:s', $trace_conf['expire']) . ' 自动关闭' : '已关闭' }})<i class="el-icon-refresh"></i></a></el-breadcrumb-item>
            </el-breadcrumb>
        </el-header>
        <el-main>
            <el-form @keyup.enter.native="onSubmit" ref="form" label-position="right" label-width="130px" :model="form">
                <el-form-item label="URL(Start with)" required>
                    <el-input placeholder="domain/path" v-model="form.url"></el-input>
                </el-form-item>
                <el-form-item label="标签名">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="用户ID" title="要监听的用户ID">
                    <el-input v-model="form.user_id"></el-input>
                </el-form-item>
                <el-form-item label="过期秒数">
                    <el-input v-model="form.expire_second"></el-input>
                </el-form-item>
                <el-form-item label="Max Depth">
                    <el-input v-model="form.max_depth"></el-input>
                </el-form-item>
                <el-form-item label="Max Data">
                    <el-input v-model="form.max_data"></el-input>
                </el-form-item>
                <el-form-item label="Max Children">
                    <el-input v-model="form.max_children"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" @click="onSubmit">保存</el-button>
                    <el-button @click="onClose">关闭</el-button>
                </el-form-item>
            </el-form>
        </el-main>
    </el-container>
</div>
<script>
    (() => {
        let form = {!! json_encode($trace_conf) !!}
        new Vue({
            el: '#app',
            data: function () {
                return {
                    form,
                }
            },
            methods: {
                onSubmit: function () {
                    $.post('/xdebug/listen', this.form, (data) => {
                        if (data.state) {
                            top.V_INSTANCE.$message({
                                showClose: true,
                                message: data.message,
                                type: 'success'
                            });
                            top.V_INSTANCE.$refs['menu'].activeIndex = '/xdebug/index';
                            location.href = '/xdebug/index';
                        } else {
                            top.V_INSTANCE.$message({
                                showClose: true,
                                message: data.message,
                                type: 'error'
                            });
                        }
                    }, 'json');
                },
                onClose: function () {
                    $.post('/xdebug/close', data => {
                        top.V_INSTANCE.$message({
                            showClose: true,
                            message: data.message,
                            type: 'success'
                        });
                        location.reload();
                    });
                }
            }
        })
    })();
</script>
</body>
</html>
