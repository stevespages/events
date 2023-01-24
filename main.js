import { showMonth } from './javascript/modules/month.js';
import { showDay } from './javascript/modules/day.js';

const monthDiv = document.querySelector('#month-div');
const dayDiv = document.querySelector('#day-div');

const date = new Date();



/*
const thisMonthQueryString = new URLSearchParams({
  yr: 2023,
  mth: 3,
});
*/

function fetchMonth(queryString){
  fetch('./php/ajax.php?' + queryString)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      monthDiv.innerHTML = showMonth(data);
      const leftArrow = document.querySelector('#left-arrow-span');
      leftArrow.addEventListener('click', function(){
        const currYr = queryString.get('yr');
        // subtract 1 from mth as JS months are indexed from 0.
        const currMth = queryString.get('mth') - 1;
        const d = new Date(currYr, currMth, 1);
        d.setMonth(d.getMonth() - 1);
        const newQueryString = new URLSearchParams({
          yr: d.getFullYear(),
          mth: d.getMonth() + 1,
        });
        fetchMonth(newQueryString);
      });
      const rightArrow = document.querySelector('#right-arrow-span');
      rightArrow.addEventListener('click', function(){
        const currYr = queryString.get('yr');
        // subtract 1 from mth as JS months are indexed from 0.
        const currMth = queryString.get('mth') - 1;
        const d = new Date(currYr, currMth, 1);
        d.setMonth(d.getMonth() + 1);
        const newQueryString = new URLSearchParams({
          yr: d.getFullYear(),
          mth: d.getMonth() + 1,
        });
        console.log(newQueryString);
        fetchMonth(newQueryString);
      });
      const monthTbody = document.querySelector('#month-tbody');
      monthTbody.addEventListener('click', function(event){
        const newQueryString = new URLSearchParams({
          yr: event.target.dataset.yr,
          mth: event.target.dataset.mth,
          day: event.target.dataset.day,
        });
        /*
        console.log(newQueryString);
        dayDiv.innerHTML = '<p>';
        dayDiv.innerHTML += event.target.dataset.yr + '-';
        dayDiv.innerHTML += event.target.dataset.mth + '-';
        dayDiv.innerHTML += event.target.dataset.day;
        dayDiv.innerHTML += '</p>';
        */
        fetchDay(newQueryString);
      });
    });
}

function fetchDay(queryString){
  fetch('./php/ajax.php?' + queryString)
    .then((response) => response.json())
    // .then((data) => console.log(data));
    .then((data) => {
      console.log(data);
      showDay(data, queryString, dayDiv);
    });
}

// Adds 1 to the month as Date starts at 0 for Jan and my PHP starts at 1.
const thisMonthQueryString = new URLSearchParams({
  yr: parseInt(date.getFullYear()),
  mth: parseInt(date.getMonth() + 1),
});
fetchMonth(thisMonthQueryString);

// Adds 1 to the month as Date starts at 0 for Jan and my PHP starts at 1.
const thisDayQueryString = new URLSearchParams({
  yr: parseInt(date.getFullYear()),
  mth: parseInt(date.getMonth() + 1),
  day: parseInt(date.getDate()),
});
fetchDay(thisDayQueryString);
