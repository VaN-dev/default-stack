import { NextPage } from 'next';
import { AdminLayout } from '@layout';
import React from 'react';
import { Form, Button } from 'react-bootstrap';
import { useRouter } from 'next/router';
import useUpdateProject from '../../../hooks/api/project/useUpdateProject';
import useGetProject from '../../../hooks/api/project/useGetProject';

const ProjectsEdit: NextPage = () => {
  const router = useRouter();
  const id = router.query.id as string;
  const { updateProject } = useUpdateProject();
  const { project } = useGetProject(id);
  const handleSubmit = async (event: React.FormEvent<HTMLFormElement>) => {
    event.preventDefault();
    const target = event.target as HTMLFormElement;

    const payload = {
      title: target.title.value,
    };

    const { data: error } = await updateProject(id, payload);

    if (!error) {
      await router.push('/projects');
    }
  };

  return (
    <AdminLayout>
      { project !== undefined ? (
        <Form onSubmit={handleSubmit}>
          <Form.Group className="mb-3" controlId="formBasicTitle">
            <Form.Label>Title</Form.Label>
            <Form.Control type="text" name="title" placeholder="Enter title" defaultValue={project.title} />
          </Form.Group>

          <Button variant="primary" type="submit">
            Submit
          </Button>
        </Form>
      ) : 'loading' }
    </AdminLayout>
  );
};
export default ProjectsEdit;
