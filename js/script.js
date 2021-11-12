var img = document.getElementById("popcat1");
var count = document.getElementById("score");
var score = getCookie("count");

const ASSET_PATH = "./assets/image";
const SOUND_PATH = "./assets";
const audio = new Audio(`${SOUND_PATH}/pop.mp3`);

const TOUCH_CAT_UP = 1;
const TOUCH_CAT_DOWN = 2;

// https://stackoverflow.com/questions/10730362/get-cookie-by-name
function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return parts.pop().split(";").shift();
}

function fetchingNewValue(firstTime) {
  let time = "";
  if (!firstTime) {
    time = `t=${Math.floor(new Date().getTime() / 1000)}`;
  }

  fetch(`/api/getValue/getCurrentValue.php?${time}`)
    .then((res) => {
      return res.json();
    })
    .then((data) => {
      updateCurrentValue(data);
      fetchingNewValue(false);
    });
}

function updateCurrentValue({ nuea, klang, esan, tai }) {
  document.getElementById("demo_1").innerHTML = nuea;
  document.getElementById("demo_2").innerHTML = klang;
  document.getElementById("demo_3").innerHTML = esan;
  document.getElementById("demo_4").innerHTML = tai;
  // todo: update the total value ui
  // document.getElementById("total").innerHTML = nuea + klang + esan + tai;
}

const touchCat = (action) => {
  action = action ? action : 0;

  // inner arrow function
  const increaseScore = () => {
    score++;
    count.innerHTML = score;
    document.cookie = `count=${score}`;
    const sb = document.querySelector("#majar");
    const Index = sb.selectedIndex;

    fetch(`/api/updateValue/UPDATE_ID_${Index}.php`)
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        console.log(data);
      });
  };

  // if we touch cat
  if (action == TOUCH_CAT_DOWN) increaseScore();

  // update cat image
  img.src = getCat(score, action);

  // check if we touch cat?
  if (action == TOUCH_CAT_DOWN || action == TOUCH_CAT_UP) audio.play();
};

const getCat = (score, action) => {
  if (score > 100) {
    return `${ASSET_PATH}/popcat${action || 2}.png`;
  } else if (score > 80) {
    return `${ASSET_PATH}/2vaccine${action || 2}.png`;
  } else if (score > 50) {
    return `${ASSET_PATH}/catvaccine${action || 2}.png`;
  } else if (score > 30) {
    return `${ASSET_PATH}/catmask${action || 2}.png`;
  }
  return `${ASSET_PATH}/maincat${action || 2}.png`;
};

// mouseclick event
document.body.addEventListener("mousedown", function () {
  touchCat(TOUCH_CAT_DOWN);
});

document.body.addEventListener("mouseup", function () {
  touchCat(TOUCH_CAT_UP);
});

// touch event
document.body.addEventListener("touchstart", function () {
  touchCat(TOUCH_CAT_DOWN);
});

document.body.addEventListener("touchmove", function () {
  touchCat(TOUCH_CAT_UP);
});

const init = () => {
  count.innerText = score;
  img.src = getCat(score, 0);

  fetchingNewValue(true);
};

window.onload = () => {
  init();
};
