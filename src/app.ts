import express from 'express';
import session from 'express-session';

import connect from './database/mongodb/connect';
import { successLog } from './utils/log';
import { HOST, PORT } from './config/constants/server';

import user from './routes/user';
import userMeasurement from './routes/userMeasurement';

const app = express();

// Configuration
	// Session
app.use(session({
	secret: 'prs-mcr',
	resave: true,
	saveUninitialized: true,
}));
	// express
app.use(express.urlencoded({ extended: true }));
app.use(express.json());
	// Connect to database
connect();

// Routes
app.get('/', (req, res) => {
	res.send('server running');
});

app.use('/user', user);
app.use('/user-measurement', userMeasurement);

app.listen(PORT, () => {
	successLog(`\n[express] Server running on http://${HOST}:${PORT}`);
});