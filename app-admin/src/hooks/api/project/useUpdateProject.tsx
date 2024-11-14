import { useState } from 'react';

import { Project } from '@models/project';
import useRequest from '../useRequest';
import { ErrorResponse } from '../../../../types/Api';

export type Payload = {
  title: string;
};

function useUpdateProject(): {
  updateProject: (id: string, payload: Payload) => Promise<{
    data: Project | undefined;
    error: ErrorResponse | undefined;
  }>;
  loading: boolean;
} {
  const request = useRequest<Project, ErrorResponse>();

  const [loading, setLoading] = useState(false);

  async function updateProject(id: string, payload: Payload) {
    setLoading(true);

    const { data, error } = await request(
      `/projects/${id}`,
      payload,
      'PUT',
    );

    setLoading(false);

    return { data, error };
  }
  return {
    updateProject,
    loading,
  };
}

export default useUpdateProject;
