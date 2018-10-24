// var config = require('./config.json');
//
// module.exports = function () {
//     var greet = document.createElement('div');
//     greet.textContent = config.GreetText;
//     return greet;
// };

import React,{Component} from 'react';
import config from './config.json';

class Greeter export Component{
    render(){
      return (
          <div>
          {config.GreetText}
          </div>
      );
    }
}

export default Greeter
