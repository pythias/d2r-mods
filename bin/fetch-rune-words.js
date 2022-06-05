// https://d2r.world/zh-TW/info/item/runewords
// 搞不定properties.txt轉換成字符串的方法，先抓站吧
const runes = document.getElementsByClassName("css-1dbjc4n r-1yflyrw r-1mi0q7o");

for (let i = 0; i < runes.length; i++) {
  const rune = runes[i];
  const title = rune.childNodes[1].innerText.replace("\n", "");

  const content = rune.childNodes[2].childNodes[0];
  const p0 = content.childNodes[0];
  const p1 = content.childNodes[1];
  const order = p0.childNodes[1].childNodes[1].innerText;
  const allowed = p0.childNodes[0].childNodes[1].innerText;
  const properties = p1.childNodes[1].innerText;

  console.info(title, order, allowed, properties);
}

