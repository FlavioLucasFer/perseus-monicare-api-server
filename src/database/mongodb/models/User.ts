import { Schema, model } from 'mongoose';

import UserEntity from '../../../domain/entities/User';
import UserMeasurement from './UserMeasurement';
import { USER_STATUS, USER_TYPES } from '../../../domain/entities/User';

const User = new Schema({
	name: {
		type: String,
		required: true,
		trim: true,
	},
	age: {
		type: Number,
		required: true,
		minLength: 1,
		maxLength: 3,
	},
	federal_document: {
		type: String,
		alias: 'federalDocument',
		required: true,
		unique: true,
		trim: true,
		minLength: 14,
		maxLength: 18,
	},
	password: {
		type: String,
		required: true,
		trim: true,
		minLength: 6,
	},
	type: {
		type: String,
		enum: [
			USER_TYPES.admin,
			USER_TYPES.doctor,
			USER_TYPES.patient,
			USER_TYPES.guardian,
		],
		default: USER_TYPES.patient,
	},
	status: {
		type: String,
		enum: [
			USER_STATUS.active, 
			USER_STATUS.inactive,
		],
		default: USER_STATUS.active,
	},
	user_measurements: {
		type: [UserMeasurement],
		alias: 'userMeasurements',
	},
}, {
	timestamps: {
		createdAt: 'created_at',
		updatedAt: 'updated_at',
	},
});

export default model<UserEntity>('users', User);
