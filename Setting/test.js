// 静的変数的な
var num = function() {
    // 変数"a"を初期化
    var a = 0;
    // 処理内容の（外側でtest関数になる）無名関数を返す
    return function() {
        // 変数"a"をカウントアップ
        a ++;
        // 変数"a"の値を返す
        return a;
    };
}();
// 最初に表示される分(title属性の値の数だけ表示)
window.onload = function() {
    // const cnt = document.getElementById("tag").title;
    const tag = document.getElementById('tag');
    const item = document.getElementById("item")
    const cnt = tag.getAttribute('data-cnt');
    for (var i = 0; i < cnt; i++) {
        CreateForm();
    }
}
// form作成する分
function CreateForm() {
    const id = document.getElementById('tag');
    const input = document.createElement("input");
    const button = document.createElement("input");
    var N = num();
    // formの属性設定、描画
    input.setAttribute("type", "text");
    input.setAttribute("value", N);
    input.setAttribute("id", "input" + N);
    id.appendChild(input);
    // buttonの属性設定、描画
    if (N != 1 && N != id.getAttribute('data-cnt') + 1) {
        button.setAttribute("type", "button");
        button.setAttribute("value", "削除");
        button.setAttribute("onclick", "RemoveForm(" + N + ")");
        button.setAttribute("id", "button" + N);
        id.appendChild(button);
    }
    // 空白
    id.appendChild(document.createElement("br"));
    id.appendChild(document.createElement("br"));
}
// form消す分
function RemoveForm(a) {
    const id = document.getElementById("tag");
    const targ1 = document.getElementById("input" + a);
    const targ2 = document.getElementById("button" + a);
    const targ3 = targ1.previousElementSibling;
    const targ4 = targ3.previousElementSibling;
    id.removeChild(targ1);
    id.removeChild(targ2);
    id.removeChild(targ3);
    id.removeChild(targ4);
}
