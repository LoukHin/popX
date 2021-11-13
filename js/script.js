const img = document.getElementById("imgClickAndChange");
const count = document.getElementById("score");
const sb = document.querySelector("#select-region");
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
  return 0;
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
      updateDisplayValue(data);

      if (data.isFinished) {
        window.location.replace("/grandopening.php");
      }

      fetchingNewValue(false);
    });
}

function changeImage() {
  const catPath = `assets/icon/cat${Math.floor(
    Math.random() * (9 - 1) + 1
  )}.svg`;
  img.src = catPath;
  audio.play();
}

function getSelectionRegion() {
  return sb.value;
}

// I know, it suck
function getNueaScore() {
  return document.getElementById("demo_1").innerText * 1;
}

function getKlangScore() {
  return document.getElementById("demo_2").innerText * 1;
}

function getEsanScore() {
  return document.getElementById("demo_3").innerText * 1;
}

function getTaiScore() {
  return document.getElementById("demo_4").innerText * 1;
}

function updateDisplayValue({ nuea, klang, esan, tai }) {
  if (nuea) document.getElementById("demo_1").innerHTML = nuea;
  if (klang) document.getElementById("demo_2").innerHTML = klang;
  if (esan) document.getElementById("demo_3").innerHTML = esan;
  if (tai) document.getElementById("demo_4").innerHTML = tai;
  // todo: update the total value ui
  // document.getElementById("total").innerHTML = nuea + klang + esan + tai;
}

const touchCat = (function () {
  let nextScore = 0;
  let currentRegion = "";

  // inner arrow function
  const updateRegionScore = () => {
    const finalScore = nextScore;
    nextScore = 0;

    if (finalScore !== 0) {
      fetch(`/api/updateValue/updateValue.php`, {
        method: "POST",
        body: JSON.stringify({
          region: currentRegion,
          add: finalScore,
        }),
      }).then((data) => {
        if (data == -1) {
          console.error("Hacker!!!!!!!!!!!!!!!!!!!!!!!");
          document.getElementById("is-hacker").style.display = "block";
        }
      });
    }
  };

  const increaseScore = () => {
    nextScore++;
    score++;
    count.innerHTML = score;

    const selectRegion = getSelectionRegion();
    if (currentRegion == "") {
      currentRegion = selectRegion;
    } else if (selectRegion !== currentRegion) {
      updateRegionScore();
      currentRegion = selectRegion;
    }

    document.cookie = `count=${score}`;

    let currentScore = 0;
    if (currentRegion === "nuea") {
      currentScore = getNueaScore();
    } else if (currentRegion === "klang") {
      currentScore = getKlangScore();
    } else if (currentRegion === "esan") {
      currentScore = getEsanScore();
    } else if (currentRegion === "tai") {
      currentScore = getTaiScore();
    }

    updateDisplayValue({ [currentRegion]: currentScore + 1 });
    console.log(nextScore, currentRegion, currentScore);
  };

  const softlyTouch = (action) => {
    // update cat image
    // img.src = getCat(score, action);
    // check if we touch cat?
    // if (action == TOUCH_CAT_DOWN || action == TOUCH_CAT_UP) audio.play();

    changeImage();

    // if we touch cat softly hand down
    if (action == TOUCH_CAT_DOWN) increaseScore();
  };

  setInterval(() => {
    updateRegionScore();
  }, 3000);

  return {
    softlyTouch,
  };
})();

// const getCat = (score, action) => {
//   if (score > 100) {
//     return `${ASSET_PATH}/popcat${action || 2}.png`;
//   } else if (score > 80) {
//     return `${ASSET_PATH}/2vaccine${action || 2}.png`;
//   } else if (score > 50) {
//     return `${ASSET_PATH}/catvaccine${action || 2}.png`;
//   } else if (score > 30) {
//     return `${ASSET_PATH}/catmask${action || 2}.png`;
//   }
//   return `${ASSET_PATH}/maincat${action || 2}.png`;
// };

// mouseclick event
document.body.addEventListener("mousedown", function () {
  touchCat.softlyTouch(TOUCH_CAT_DOWN);
});

document.body.addEventListener("mouseup", function () {
  touchCat.softlyTouch(TOUCH_CAT_UP);
});

// touch event
document.body.addEventListener("touchstart", function () {
  touchCat.softlyTouch(TOUCH_CAT_DOWN);
});

document.body.addEventListener("touchmove", function () {
  touchCat.softlyTouch(TOUCH_CAT_UP);
});

const init = () => {
  if (score > 0) count.innerText = score;
  fetchingNewValue(true);
};

(function () {
  init();
})();
