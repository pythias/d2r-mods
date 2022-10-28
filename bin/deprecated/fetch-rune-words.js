// https://d2r.world/zh-TW/info/item/runewords
const elements = document.getElementsByClassName("css-1dbjc4n r-1yflyrw r-1mi0q7o");
const items = [];

function get_tips(element) {
  const lines = [];
  for (let i = 0; i < element.childElementCount; i++) {
    const tmp = element.childNodes[i]
    lines.push(`ÿc0${monster.name} ${with_color(monster.type)} ${with_color(monster.res)}`);
  }
  return lines.join("\n")
}

function get_runes(element) {
  const runes = [];
  for (let i = 0; i < element.childElementCount; i++) {
    const tmp = element.childNodes[i].innerText.split("\n");
    runes.push({
      'cn': tmp[0].trim(),
      'en': tmp[1].trim(),
      'id': tmp[2].trim().replace("#", "")
    });
  }
  return runes;
}

for (let i = 0; i < elements.length; i++) {
  const element = elements[i];

  const elementTitle =  element.childNodes[1];
  let tmp = elementTitle.innerText.trim().split("\n");
  const cn = tmp[0].trim();
  const en = tmp[1].trim().replace("(", "").replace(")", "");

  const elementContent = element.childNodes[2].childNodes[0];
  const elementRunes = elementContent.childNodes[0].childNodes[1].childNodes[1];
  const elementTypes = elementContent.childNodes[0].childNodes[0].childNodes[1];
  const elementEffect = elementContent.childNodes[1].childNodes[1];

  console.info(elementContent);
  const runes = get_runes(elementRunes);
  const types = elementTypes.innerText.replace("", "").trim().split("\n");
  const requireLevel = elementEffect.childNodes[0].innerText.trim().split("：")[1];
  const tips = get_tips(elementEffect.childNodes[1]);

  console.info(runes, types, requireLevel, tips);
  
}
