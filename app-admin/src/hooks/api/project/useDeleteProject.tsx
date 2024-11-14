import { useState } from 'react';

import { Project } from '@models/project';
import useRequest from '../useRequest';
import { ErrorResponse } from '../../../../types/Api';

function useDeleteProject(): {
  deleteProject: (id: string) => Promise<{
    data: Project | undefined;
    error: ErrorResponse | undefined;
  }>;
  loading: boolean;
} {
  const request = useRequest<Project, ErrorResponse>();

  const [loading, setLoading] = useState(false);

  async function deleteProject(id: string) {
    setLoading(true);

    const { data, error } = await request(
      `/projects/${id}`,
      null,
      'DELETE',
    );

    setLoading(false);

    return { data, error };
  }
  return {
    deleteProject,
    loading,
  };
}

export default useDeleteProject;
