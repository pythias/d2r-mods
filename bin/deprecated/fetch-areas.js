// https://d2r.world/zh-TW/info/monster/alvl85
const elements = document.getElementsByClassName("css-1dbjc4n r-1awozwy r-qklmqi r-1c549yc r-18u37iz r-1w6e6rj r-1w50u8q");
const items = [];

function with_color(text) {
  if (text.includes("惡魔")) {
    return "ÿc7" + text;
  }

  if (text.includes("動物")) {
    return "ÿc8" + text;
  }
  
  if (text.includes("不死")) {
    return "ÿc5" + text;
  }
  
  if (text.includes("電")) {
    return "ÿc9" + text;
  }

  if (text.includes("冰")) {
    return "ÿc3" + text;
  }

  if (text.includes("毒")) {
    return "ÿc2" + text;
  }

  if (text.includes("火")) {
    return "ÿc1" + text;
  }

  return text;
}

function tips(monsters) {
  const lines = [];
  for (let i = 0; i < monsters.length; i++) {
    const monster = monsters[i];
    lines.push(`ÿc0${monster.name} ${with_color(monster.type)} ${with_color(monster.res)}`);
  }
  return lines.join("\n")
}

for (let i = 0; i < elements.length; i++) {
  const area = elements[i];
  tmp = area.childNodes[0].innerText.trim().split("@");
  const title = tmp[0].trim();
  let location = "";
  if (tmp.length > 1) {
    location = tmp[1].trim();
  }
  
  const monsters = [];
  for (let j = 0; j < area.childNodes[1].childElementCount; j++) {
    tmp = area.childNodes[1].childNodes[j].innerText.split("\n");
    if (tmp.length < 3) { 
      continue;
    }
    const monster = {
      "name": tmp[0].trim(),
      "type": tmp[1].trim(),
      "res": tmp[2].trim(),
    };
    monsters.push(monster);
  }

  items.push({
    "id": 1000000 + i * 3,
    "Key": "ztmf"+i+"n",
    "zhTW": title
  },{
    "id": 1000000 + i * 3 + 1,
    "Key": "ztmf"+i+"l",
    "zhTW": location
  },{
    "id": 1000000 + i * 3 + 2,
    "Key": "ztmf"+i+"t",
    "zhTW": tips(monsters)
  });
}

console.info(JSON.stringify(items));

const areas = [];
for (let i = 0; i < items.length; i++) {
  areas.push({
    "type": "TableRowWidget",
    "name": "MRItem",
    "children": [
        {
            "type": "TextBoxWidget",
            "name": "MRName",
            "fields": {
                "text": "@ztmf" + i + "n",
                "style": "$StyleModGold"
            }
        },
        {
            "type": "TextBoxWidget",
            "name": "MRLocation",
            "fields": {
                "text": "@ztmf" + i + "l",
                "style": "$StyleModWhite"
            }
        },
        {
            "type": "FocusableWidget",
            "name": "MRTips",
            "fields": {
                "fitToParent": true,
                "tooltipString": "@ztmf" + i + "t",
                "tooltipStyle": {
                    "fontStyle": {
                        "options": {
                            "newlineHandling": "standard"
                        }
                    }
                }
            }
        }
    ]
  });
}

console.info(JSON.stringify(areas));

