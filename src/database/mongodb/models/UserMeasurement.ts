import { Schema } from 'mongoose';

import UserMeasurementEntity from '../../../domain/entities/UserMeasurement';

const UserMeasurement = new Schema<UserMeasurementEntity>({
	body_temperature: {
		type: Number,
		alias: 'bodyTemperature',
		required: true,
		minLength: 2,
		maxLength: 2,
	},
	blood_oxygenation: {
		type: Number,
		alias: 'bloodOxygenation',
		required: true,
	},
	heart_rate: {
		type: Number,
		alias: 'heartRate',
		required: true,
	},
	measured_at: {
		type: Date,
		alias: 'measuredAt',
	},
}, {
	timestamps: {
		createdAt: 'created_at',
		updatedAt: 'updated_at',
	},
});

export default UserMeasurement;