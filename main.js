import { showMonth } from './javascript/modules/month.js';
import { showDay } from './javascript/modules/day.js';
import { showVirtualcrossing } from './javascript/modules/virtualcrossing.js';

const monthDiv = document.querySelector('#month-div');
const dayDiv = document.querySelector('#day-div');
const virtualcrossingDiv = document.querySelector('#virtualcrossing-div');

// today's date
const todayDate = new Date();
const todayYr = parseInt(todayDate.getFullYear());
const todayMth = parseInt(todayDate.getMonth());
const todayDay = parseInt(todayDate.getDate());

function fetchMonth(yr, mth){
  // This could be used to automatically display today's events and ...
  // ...visualcrossing data. Currently it just returns false so the...
  // ...information is not automatically displayed.
  function isTodayDisplayed(){
    return false;
  }
  // Adds 1 to the month as JS indexed from 0 (Jan). My PHP starts at 1.
  const queryString = new URLSearchParams({
    yr: yr,
    mth: mth + 1,
  });
  fetch('./php/ajax.php?' + queryString)
    .then((response) => response.json())
    .then((data) => {
      console.log('data', data);
      monthDiv.innerHTML = showMonth(data);
      dayDiv.innerHTML = '';
      virtualcrossingDiv.innerHTML = '';
      const leftArrow = document.querySelector('#left-arrow-span');
      leftArrow.addEventListener('click', function(){
        const displayedDate = new Date(yr, mth, 1);
        const newDate = new Date(
          displayedDate.setMonth(displayedDate.getMonth() - 1)
        );
          const newYr = newDate.getFullYear();
          const newMth = newDate.getMonth();
        fetchMonth(newYr, newMth);
      });
      const rightArrow = document.querySelector('#right-arrow-span');
      rightArrow.addEventListener('click', function(){
        const displayedDate = new Date(yr, mth, 1);
        const newDate = new Date(
          displayedDate.setMonth(displayedDate.getMonth() + 1)
        );
          const newYr = newDate.getFullYear();
          const newMth = newDate.getMonth();
        fetchMonth(newYr, newMth);
      });
      const monthTbody = document.querySelector('#month-tbody');
      monthTbody.addEventListener('click', function(event){
        const selectedDays = document.querySelectorAll('.selected-day');
        for(let i = 0; i < selectedDays.length; i++){
          selectedDays[i].classList.remove('selected-day');
        }
        event.target.classList.add('selected-day');
          const newYr = event.target.dataset.yr;
          const newMth = event.target.dataset.mth;
          const newDay = event.target.dataset.day;
        fetchDay(newYr, newMth, newDay);

        virtualcrossingDiv.innerHTML = '';
        if(
          newYr == todayYr &&
          newMth - 1 == todayMth &&
          newDay == todayDay
        )
        {
          fetchVirtualcrossing();
        }
      });
    });
  // Needs to be be implemented to automatically display todays events
  if(isTodayDisplayed()){
    // Add 1 to  mth as JS index starts at 0 for Jan and my PHP starts at 1.
    const thisDayQueryString = new URLSearchParams({
    yr: yr,
    mth: mth + 1,
    day: day,
    });
    fetchDay(thisDayQueryString);
  }

}

function fetchDay(yr, mth, day){
  const queryString = new URLSearchParams({
    yr: yr,
    mth: mth,
    day: day,
  });
  fetch('./php/ajax.php?' + queryString)
    .then((response) => response.json())
    .then((data) => {
      showDay(data, queryString, dayDiv);
    });
}

function fetchVirtualcrossing(){
  let url = 'https://weather.visualcrossing.com/';
  url += 'VisualCrossingWebServices/rest/services/timeline/';
  url += 'Swindon?';
  url += 'unitGroup=metric&';
  url += 'include=days&';
  url += 'key=NZGDNG8GKVZ45HTYNC94KLBME&';
  url += 'contentType=json';
  fetch(url, {
    'method': 'GET',
    'headers': {
    }
  })
    .then((response) => response.json())
    .then((data) => {
      showVirtualcrossing(data, virtualcrossingDiv);
    });
}

fetchMonth(todayYr, todayMth);
