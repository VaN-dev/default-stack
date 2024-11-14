import React from 'react';
import { UserContextType } from '../../types/Contexts';

const UserContext = React.createContext<UserContextType>({});

export default UserContext;
