import mongoose from 'mongoose';

import { successLog, errorLog } from '../../utils/log';
import { HOST, DATABASE } from '../../config/constants/database';

async function connect() : Promise<void> {
	try {
		mongoose.Promise = global.Promise;
		await mongoose.connect(`mongodb://${HOST}/${DATABASE}`, {
			useNewUrlParser: true,
			useUnifiedTopology: true,
			useCreateIndex: true,
			useFindAndModify: false,
		});

		successLog(`[mongodb/${HOST}/${DATABASE}] Successfully connected to database!`);
	} catch (err) {
		errorLog(`[mongodb/${HOST}/${DATABASE}] Failed to connect to database!`);
		errorLog(`Error: ${err}`);
	}
}

export default connect;