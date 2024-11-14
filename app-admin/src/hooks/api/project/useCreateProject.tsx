import { useState } from 'react';

import { Project } from '@models/project';
import useRequest from '../useRequest';
import { ErrorResponse } from '../../../../types/Api';

export type CreateProjectPayload = {
  title: string;
};

function useCreateProject(): {
  createProject: (payload: CreateProjectPayload) => Promise<{
    data: Project | undefined;
    error: ErrorResponse | undefined;
  }>;
  loading: boolean;
} {
  const request = useRequest<Project, ErrorResponse>();

  const [loading, setLoading] = useState(false);

  async function createProject(payload: CreateProjectPayload) {
    setLoading(true);

    const { data, error } = await request(
      '/projects',
      payload,
      'POST',
    );

    setLoading(false);

    return { data, error };
  }
  return {
    createProject,
    loading,
  };
}

export default useCreateProject;
