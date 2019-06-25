export const user = state => state.user

export const hasBoards = state => {
  return state.boards.length > 0
}

export const personalBoards = state => {
  return state.boards.filter(board => board.team_id === null)
}

export const teamBoards = state => {
  const teams = []

  state.teams.forEach(team => {
    teams.push({
      id: team.id,
      name: team.name,
      boards: state.boards.filter(board => board.team_id === team.id)
    })
  })

  return teams
}
