<html>
    <body>
        <div><?php
            if ($hash) {
                echo '変換後URL【 <a href="' . $jump . '" target="_blank">' . $jump . '</a> 】';
            }
        ?></div>
        <br /><br />
        <div>↓にURLを記入して短縮ボタンをクリック！</div>
        <form action='/' method='post'>
            <textarea name='url' style="width:100%; height:400px;"></textarea>
            <br />
            <br />
            <div style="text-align: center;">
                <button style="width:200px; height: 50px;">短縮</button>
            </div>
        </form>
    </body>
</html>
