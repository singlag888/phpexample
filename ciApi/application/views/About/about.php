<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1,user-scalable=no,maximum-scale=1,width=device-width,minimal-ui">
    <title>关于我们</title>

    <style type="text/css">
        .content {
            background: #F5F5F5;
            width: 100%;
            height: 100%;
            padding: 0px;
            margin: 0px;
        }

        .icon {
            width: 100px;
            height: 100px;
            display: block;
            margin: auto;
            margin-top: 20%;
        }

        .info {
            margin-top: 10%;
            text-align: center;
            font-size: 24px;
        }

        p.info {
            font-size: 18px;
            text-align: start;
            text-indent: 36px;
            padding: 16px;
        }

    </style>
</head>
<body class="content">


<div>

    <?php $this->load->helper('url'); ?>
    <img class="icon" src="<?php echo base_url() . 'img/ic_launcher_round.png'; ?>" alt="">


    <h4 class="info">版本: 1.0.0</h4>

    <p class="info">
        T助手聚合数百万用户的优质内容，以图片和视频方式展示，让你随心所欲浏览。关注你感兴趣的任何话题，并且内容不断更新。发现你甚至不知道它存在的新话题。
    </p>


</div>

</body>
</html>