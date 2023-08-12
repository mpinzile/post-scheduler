const moment = require('moment-timezone');

const currentUtcDate = moment.utc();

const eastAfricanDate = currentUtcDate.tz('Africa/Nairobi').format('YYYY-MM-DD');

const eastAfricanTime = currentUtcDate.tz('Africa/Nairobi').format('HH:mm');

module.exports = {eastAfricanDate,eastAfricanTime};